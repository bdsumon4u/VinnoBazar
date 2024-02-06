<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Slider;
use App\Page;
use Illuminate\Http\Request;
use Spatie\GoogleTagManager\GoogleTagManagerFacade;

class WebsiteController extends Controller
{
    public function index()
    {
        GoogleTagManagerFacade::set([
            'event' => 'page_view',
            'page_type' => 'home',
        ]);
        $slug = 'offer';
        $topProducts = Product::with('media', 'categories')->whereHas('categories', function ($query) use ($slug) {
            $query->where('categories.categorySlug', 'like', $slug);
        })->inRandomOrder()->limit(12)->get();
        $otherProducts = Product::with('media', 'categories')->paginate(30);
        $otherProducts->withPath('shop/');
        $slides = Slider::where('status', 'Active')->limit(3)->get();
        return view('website.home', compact('slug', 'topProducts', 'otherProducts', 'slides'));
    }

    public function product($id)
    {
        $product = Product::with('media', 'categories')->where('products.id', 'like', $id)->firstOrFail();
        GoogleTagManagerFacade::set([
            'event' => 'view_item',
            'ecommerce' => [
                'currency' => 'BDT',
                'value' => $product->productSalePrice,
                'items' => [
                    [
                        'item_id' => $product->id,
                        'item_name' => $product->productName,
                        'price' => $product->productSalePrice,
                        'item_category' => $product->categories->first()->categoryName,
                        'quantity' => 1,
                    ],
                ],
            ],
        ]);
        $relatedProducts = Product::with('media', 'categories')->where('products.id', '!=', $product->id)->limit(30)->get();
        return view('website.product', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $categoryProducts = Product::with('media', 'categories')->whereHas('categories', function ($query) use ($slug) {
            $query->where('categories.categorySlug', 'like', $slug);
        })->paginate(30);
        $category = Category::where('categories.categorySlug', $slug)->first();
        GoogleTagManagerFacade::set([
            'event' => 'view_item_list',
            'ecommerce' => [
                'item_list_id' => $category->id,
                'item_list_name' => $category->categoryName,
                'items' => $categoryProducts->map(function ($product) {
                    return [
                        'item_id' => $product->id,
                        'item_name' => $product->productName,
                        'price' => $product->productSalePrice,
                        'item_category' => $product->categories->first()->categoryName,
                        'quantity' => 1,
                    ];
                })->toArray(),
            ],
        ]);
        return view('website.category', compact('category', 'categoryProducts'));
    }

    public function shop()
    {
        if (isset($_REQUEST['q'])) {
            GoogleTagManagerFacade::set([
                'event' => 'search',
                'search_term' => $_REQUEST['q'],
            ]);
            $shop = Product::with('media', 'categories')->where('products.productName', 'like', "%{$_REQUEST['q']}%")->paginate(30);
        } else {
            GoogleTagManagerFacade::set([
                'event' => 'page_view',
                'page_type' => 'shop',
            ]);
            $shop = Product::with('media', 'categories')->paginate(30);
        }
        return view('website.shop', compact('shop'));
    }

    public function page($slug)
    {
        $page = Page::where('pageSlug', 'like', $slug)->first();
        GoogleTagManagerFacade::set([
            'event' => 'page_view',
            'page_type' => 'page',
            'content' => $page->toArray(),
        ]);
        $relatedProducts = Product::with('media', 'categories')->inRandomOrder()->limit(30)->get();
        return view('website.page', compact('page', 'relatedProducts'));
    }
    public function loadProducts()
    {

        $otherProducts = Product::with('media', 'categories')->inRandomOrder()->paginate(30);
        foreach ($otherProducts as $product) { ?>
            <div class="col-md-2 col-6">
                <div href="#" class="card card-product-grid product-box-2">
                    <a href="<?php echo url('/product/' . $product->id)  ?>" class="img-wrap">
                        <img class="img-fit lazyload" src="<?php echo asset('product/thumbnail/default.jpg') ?>" data-src="<?php echo asset('/product/thumbnail/' . $product->productImage)  ?>" alt="<?php echo $product->productName  ?>">
                    </a>
                    <figcaption class="info-wrap">
                        <a href="<?php echo url('/product/' . $product->id)  ?>" class="title text-truncate"><?php echo $product->productName  ?></a>
                        <div class="price mt-1 text-center">
                            <?php echo $product->htmlPrice() ?>
                        </div>
                    </figcaption>
                    <button class="btn btn-success btn-sm btn-block" onclick="addToCart(<?php echo $product->id ?>)">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> অর্ডার করুন
                    </button>
                </div>
            </div>
<?php }
    }
}

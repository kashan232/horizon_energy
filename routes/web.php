<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Sub_cat_Cotnroller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KitchenInventoryController;
use App\Http\Controllers\MenuEstimateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffSalaryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\GiveOrderController;
use App\Http\Controllers\DealController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// code deploy
// pos start
// Old Pos setup
// Software deployed
// Checking

Route::get('/', [HomeController::class, 'welcome']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'home'])->middleware(['auth'])->name('home');
Route::get('/admin-page', [HomeController::class, 'adminpage'])->middleware(['auth', 'admin'])->name('admin-page');
Route::get('/Admin-Change-Password', [HomeController::class, 'Admin_Change_Password'])->name('Admin-Change-Password');
Route::post('/updte-change-Password', [HomeController::class, 'updte_change_Password'])->name('updte-change-Password');

// staff dashboard work
Route::get('/get-products-by-category', [HomeController::class, 'getProductsByCategory'])->name('get.products.by.category');
Route::get('/get-product-by-barcode', [HomeController::class, 'getProductByBarcode'])->name('get.product.by.barcode');


//category
Route::get('/category', [CategoryController::class, 'category'])->middleware(['auth', 'admin'])->name('category');
Route::post('/store-category', [CategoryController::class, 'store_category'])->name('store-category');
Route::post('/update-category', [CategoryController::class, 'update_category'])->name('update-category');

//Sub category
Route::get('/sub-category', [Sub_cat_Cotnroller::class, 'sub_category'])->middleware(['auth', 'admin'])->name('subcategory');
Route::post('/sub-store-category', [Sub_cat_Cotnroller::class, 'store_sub_category'])->name('store-subcategory');
Route::post('/sub-update-category', [Sub_cat_Cotnroller::class, 'update_sub_category'])->name('update-subcategory');


//brand
Route::get('/brand', [BrandController::class, 'brand'])->middleware(['auth', 'admin'])->name('brand');
Route::post('/store-brand', [BrandController::class, 'store_brand'])->name('store-brand');
Route::post('/update-brand', [BrandController::class, 'update_brand'])->name('update-brand');
Route::delete('/brand/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');

//unit
Route::get('/unit', [UnitController::class, 'unit'])->middleware(['auth', 'admin'])->name('unit');
Route::post('/store-unit', [UnitController::class, 'store_unit'])->name('store-unit');
Route::post('/update-unit', [UnitController::class, 'update_unit'])->name('update-unit');

//start product
Route::get('/all-product', [ProductController::class, 'all_product'])->middleware(['auth', 'admin'])->name('all-product');
Route::get('/add-product', [ProductController::class, 'add_product'])->middleware(['auth', 'admin'])->name('add-product');
Route::post('/store-product', [ProductController::class, 'store_product'])->name('store-product');
Route::get('/edit-product/{id}', [ProductController::class, 'edit_product'])->middleware(['auth', 'admin'])->name('edit-product');
Route::post('/update-product/{id}', [ProductController::class, 'update_product'])->name('update-product');
Route::get('/product-alerts', [ProductController::class, 'product_alerts'])->name('product-alerts');
Route::get('/get-subcategories/{category}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
Route::get('/get-items/{category}/{subcategory}', [ProductController::class, 'getItems'])->name('get.items');
Route::get('/search-products', [ProductController::class, 'searchProducts'])->name('search-products');
//end product

//start Deals
Route::get('/products/search', [DealController::class, 'search'])->name('products.search');

Route::get('/deals', [DealController::class, 'index'])->middleware(['auth', 'admin'])->name('deal.index');
Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
Route::get('/deals/create', [DealController::class, 'create'])->name('deal.create');
Route::get('/deal/{id}', [DealController::class, 'show'])->name('deals.show');
Route::post('/deals/{id}/toggle', [DealController::class, 'toggleStatus'])->name('deal.toggle');
Route::post('/deals/update', [DealController::class, 'updatedeal'])->name('deal.update');
Route::delete('/deals/{id}', [DealController::class, 'destroy'])->name('deal.destroy');
    // // Public Side
Route::get('/all-deals', [DealController::class, 'webpage'])->name('all-deal.public');
Route::get('/edit-deals/{id}', [DealController::class, 'edit'])->name('deal.edit');
//end Deals
//end Deals

    // Cart Side
    Route::get('/cart', [DealController::class, 'showCart'])->name('cart.show');
    Route::post('/client-info-store', [DealController::class, 'storeClientInfo'])->name('client.info.store');
    Route::post('/cart/add/{id}', [DealController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/place-order', [DealController::class, 'placeOrder'])->name('cart.place-order');
    // Route::get('/cart/remove/{id}', [DealController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart/remove/{id}', [DealController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/all-order', [OrderController::class, 'all_order'])->middleware(['auth', 'admin'])->name('all-order');
Route::get('/add-order', [OrderController::class, 'add_order'])->middleware(['auth', 'admin'])->name('add-order');
Route::post('/store-order', [OrderController::class, 'store_order'])->name('store-order');
Route::get('/invoice/{id}', [OrderController::class, 'show'])->name('invoice.show');
Route::post('/order/payment', [OrderController::class, 'paymentUpdate'])->name('order.payment');
Route::get('/Voucher/{id}', [OrderController::class, 'show_voucher'])->name('Voucher.show');
Route::get('/order-alerts', [OrderController::class, 'orderAlerts'])->name('order.alerts');
// Order Status Update Route
Route::post('/order/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

Route::post('/save-order', [OrderController::class, 'save_order'])->name('save.order');

Route::get('/online-order', [OrderController::class, 'online_order'])->name('online-order');
Route::post('/gatepass/store', [OrderController::class, 'store'])->name('gatepass.store');
Route::get('/get-order-inventory/{order}', [OrderController::class, 'getOrderInventory'])->name('get.order.inventory');


Route::get('/get-passes', [OrderController::class, 'get_passes'])->name('get-passes');
Route::get('/gatepass/inventory/{id}', [OrderController::class, 'getGatePassInventory'])->name('gatepass.inventory');

Route::post('/gatepass/return', [OrderController::class, 'returnGatePass'])->name('gatepass-return');


//Order

//Order
Route::get('/all-menu', [MenuEstimateController::class, 'all_menu'])->middleware(['auth', 'admin'])->name('all-menu');
Route::get('/add-menu', [MenuEstimateController::class, 'add_menu'])->middleware(['auth', 'admin'])->name('add-menu');
Route::post('/store-menu', [MenuEstimateController::class, 'store_menu'])->name('store-menu');
Route::get('/menu-invoice/{id}', [MenuEstimateController::class, 'show'])->name('menu.invoice.show');
Route::get('/estimate/print/{id}', [MenuEstimateController::class, 'print'])->name('estimate.print');
Route::get('/edit-order/{id}', [MenuEstimateController::class, 'edit_order'])->middleware(['auth', 'admin'])->name('edit-order');
Route::post('/update-order/{id}', [MenuEstimateController::class, 'update_order'])->name('update-order');
Route::post('/menu-estimate/confirm-order', [MenuEstimateController::class, 'confirmOrder'])->name('menu.confirm.order');


// Route::post('/store-product', [ProductController::class, 'store_product'])->name('store-product');
// Route::get('/edit-product/{id}', [ProductController::class, 'edit_product'])->middleware(['auth','admin'])->name('edit-product');
// Route::post('/update-product/{id}', [ProductController::class, 'update_product'])->name('update-product');
// Route::get('/product-alerts', [ProductController::class, 'product_alerts'])->name('product-alerts');
// Route::get('/get-subcategories/{category}', [ProductController::class, 'getSubcategories']);
// menu Items

//warehouse
Route::get('/warehouse', [WarehouseController::class, 'warehouse'])->middleware(['auth', 'admin'])->name('warehouse');
Route::post('/store-warehouse', [WarehouseController::class, 'store_warehouse'])->name('store-warehouse');
Route::post('/update-warehouse', [WarehouseController::class, 'update_warehouse'])->name('update-warehouse');

//supplier
Route::get('/supplier', [SupplierController::class, 'supplier'])->middleware(['auth', 'admin'])->name('supplier');
Route::post('/store-supplier', [SupplierController::class, 'store_supplier'])->name('store-supplier');
Route::post('/update-supplier', [SupplierController::class, 'update_supplier'])->name('update-supplier');
Route::resource('supplier-payments', SupplierPaymentController::class);
Route::post('payments/store', [SupplierPaymentController::class, 'store'])->name('payments.store');

//Staff
Route::get('/staff', [StaffController::class, 'staff'])->middleware(['auth', 'admin'])->name('staff');
Route::post('/store-staff', [StaffController::class, 'store_staff'])->name('store-staff');
Route::post('/update-staff', [StaffController::class, 'update_staff'])->name('update-staff');

//Staff Salary

Route::get('/staff-salaries', [StaffSalaryController::class, 'index'])->name('staff_salaries.index');
Route::post('/staff-salaries/get-details', [StaffSalaryController::class, 'getSalaryDetails'])->name('staff_salaries.details');
Route::post('/staff-salaries/store', [StaffSalaryController::class, 'store'])->name('staff_salaries.store');

// Expense
Route::get('/expenses', [ExpenseController::class, 'index'])->middleware(['auth', 'admin'])->name('expenses');
Route::post('/store-expense', [ExpenseController::class, 'store'])->name('store-expense');
Route::post('/update-expense', [ExpenseController::class, 'update'])->name('update-expense');


//Purchase
Route::get('/Purchase', [PurchaseController::class, 'Purchase'])->middleware(['auth', 'admin'])->name('Purchase');
Route::get('/add-purchase', [PurchaseController::class, 'add_purchase'])->middleware(['auth', 'admin'])->name('add-purchase');
Route::post('/store-Purchase', [PurchaseController::class, 'store_Purchase'])->name('store-Purchase');
// Route::post('/update-Purchase', [PurchaseController::class, 'update_Purchase'])->name('update.purchase');
Route::post('/purchases-payment', [PurchaseController::class, 'purchases_payment'])->name('purchases-payment');
Route::get('/get-items-by-category/{categoryId}', [PurchaseController::class, 'getItemsByCategory'])->name('get-items-by-category');


Route::get('/purchase-view/{id}', [PurchaseController::class, 'view'])->name('purchase-view');
Route::get('/purchase-return/{id}', [PurchaseController::class, 'purchase_return'])->name('purchase-return');
Route::post('/store-purchase-return', [PurchaseController::class, 'store_purchase_return'])->name('store-purchase-return');
Route::get('/all-purchase-return', [PurchaseController::class, 'all_purchase_return'])->name('all-purchase-return');
Route::post('/purchase-return-payment', [PurchaseController::class, 'purchase_return_payment'])->name('purchase-return-payment');
Route::get('/get-unit-by-product/{productId}', [PurchaseController::class, 'getUnitByProduct'])->name('get-unit-by-product');


Route::get('/purchase-return-damage-item/{id}', [PurchaseController::class, 'purchase_return_damage_item'])->name('purchase-return-damage-item');
Route::post('/store-purchase-return-damage-item', [PurchaseController::class, 'store_purchase_return_damage_item'])->name('store-purchase-return-damage-item');
Route::get('/all-purchase-return-damage-item', [PurchaseController::class, 'all_purchase_return_damage_item'])->name('all-purchase-return-damage-item');
Route::get('purchase/edit/{id}', [PurchaseController::class, 'edit'])->name('edit.purchase');
Route::post('purchase/update', [PurchaseController::class, 'update'])->name('purchase.update');


//start Sale route
Route::get('/sales-return/{id}', [SaleController::class, 'salesreturn'])->name('sales-return');
Route::get('/Sale', [SaleController::class, 'Sale'])->name('Sale');
Route::get('/add-Sale', [SaleController::class, 'add_Sale'])->name('add-Sale');
Route::post('/store-Sale', [SaleController::class, 'store_Sale'])->name('store-Sale');
Route::get('/all-sales', [SaleController::class, 'all_sales'])->name('all-sales');
Route::get('/get-customer-amount/{id}', [SaleController::class, 'get_customer_amount'])->name('get-customer-amount');
Route::get('/sale/edit/{id}', [SaleController::class, 'edit'])->name('sale.edit');
Route::post('/sale/update/{id}', [SaleController::class, 'update'])->name('sale.update');
Route::get('/Sale/return/view', [SaleController::class, 'Salereturnview'])->name('Sale.returnview');
Route::post('/store-sales-return', [SaleController::class, 'storeSalesReturn'])->name('store-sales-return');
Route::get('/invoice/download/{id}', [SaleController::class, 'downloadInvoice'])->name('invoice.download');
Route::get('/get-product-details/{productName}', [ProductController::class, 'getProductDetails'])->name('get-product-details');
Route::get('/sale-receipt/{id}', [SaleController::class, 'showReceipt'])->name('sale-receipt');
Route::get('/sale-view/{id}', [SaleController::class, 'view'])->name('sale-view');
//end Sale route

// Route for downloading invoice




//Customer
Route::get('/customer', [CustomerController::class, 'customer'])->name('customer');
Route::post('/store-customer', [CustomerController::class, 'store_customer'])->name('store-customer');
Route::post('/update-customer', [CustomerController::class, 'update_customer'])->name('update-customer');
Route::post('/customer/recovery', [CustomerController::class, 'processRecovery'])->name('customer.recovery');
Route::get('/customer-recovires', [CustomerController::class, 'customer_recovires'])->middleware(['auth', 'admin'])->name('customer-recovires');
Route::post('/customer/credit', [CustomerController::class, 'addCredit'])->name('customer.credit');

// socail media customers

Route::get('/socialcustomer', [CustomerController::class, 'social_customer'])->name('social_customer');
Route::post('/social-store-customer', [CustomerController::class, 'social_store_customer'])->name('social_store-customer');
Route::post('/social-update-customer', [CustomerController::class, 'social_update_customer'])->name('social-update-customer');
Route::post('/social-confirm-customer/{id}', [CustomerController::class, 'confirm_social_customer'])->name('social-confirm-customer');


//Vendors


Route::get('/vendor', [VendorController::class, 'vendor'])->name('vendor1');
Route::post('/store-vendor', [VendorController::class, 'store_vendor'])->name('store-vendor');
Route::post('/update-vendor', [VendorController::class, 'update_vendor'])->name('update-vendor');
// Vendor screen dekhne ka route
Route::get('/give-vendor', [GiveOrderController::class, 'vendor'])->name('vendor');

// Vendor create karne ka route
Route::post('/store-vendor', [GiveOrderController::class, 'store_vendor'])->name('store-vendor');

// Vendor update karne ka route
Route::post('/update-vendor', [GiveOrderController::class, 'update_vendor'])->name('update-vendor');

// 🎯 New: Vendor ko Order assign karne ka route
Route::post('/assign-order-to-vendor', [GiveOrderController::class, 'assignOrderToVendor'])->name('assign-order-to-vendor');
Route::get('/Accountant', [AccountantController::class, 'Accountant'])->middleware(['auth', 'admin'])->name('Accountant');
Route::post('/store-Accountant', [AccountantController::class, 'store_Accountant'])->name('store-Accountant');
Route::post('/update-Accountant', [AccountantController::class, 'update_Accountant'])->name('update-Accountant');

Route::post('/update-payment', [AccountantController::class, 'update_payment'])->name('update-payment');
Route::get('/Accountant-Ledger', [AccountantController::class, 'Accountant_Ledger'])->name('Accountant-Ledger');


Route::get('/Accountant-Expense', [AccountantController::class, 'Accountant_Expense'])->name('Accountant-Expense');
Route::post('/save-accountant-expense', [AccountantController::class, 'saveExpense'])->name('save-accountant-expense');

Route::prefix('kitchen')->group(function () {
    Route::get('/inventory', [KitchenInventoryController::class, 'index'])->name('kitchen.inventory');
    Route::post('/add-item', [KitchenInventoryController::class, 'storeItem'])->name('kitchen-items.store');
    Route::post('/add-inventory', [KitchenInventoryController::class, 'storeInventory'])->name('inventory.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';

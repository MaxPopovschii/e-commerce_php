<?php

session_start();

require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/CartController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/OrderController.php';
require_once __DIR__ . '/../controllers/ReviewController.php';
require_once __DIR__ . '/../controllers/WishlistController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/ApiController.php';
require_once __DIR__ . '/../controllers/CouponController.php';
require_once __DIR__ . '/../controllers/ShippingController.php';
require_once __DIR__ . '/../controllers/BlogController.php';
require_once __DIR__ . '/../controllers/SupportController.php';
require_once __DIR__ . '/../controllers/InventoryController.php';
require_once __DIR__ . '/../controllers/ActivityLogController.php';
require_once __DIR__ . '/../controllers/BackupController.php';
require_once __DIR__ . '/../controllers/SocialLoginController.php';
require_once __DIR__ . '/../controllers/ExportController.php';
require_once __DIR__ . '/../controllers/NotificationController.php';

$page = $_GET['page'] ?? 'products';
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

switch ($page) {
    case 'products':
        $controller = new ProductController();
        if ($id) $controller->show($id);
        else $controller->index();
        break;
    case 'cart':
        $controller = new CartController();
        if ($action === 'add' && $id) $controller->add($id);
        elseif ($action === 'remove' && $id) $controller->remove($id);
        elseif ($action === 'clear') $controller->clear();
        else $controller->index();
        break;
    case 'users':
        $controller = new UserController();
        if ($action === 'login') $controller->login();
        elseif ($action === 'register') $controller->register();
        elseif ($action === 'profile') $controller->profile();
        elseif ($action === 'logout') $controller->logout();
        else $controller->login();
        break;
    case 'orders':
        $controller = new OrderController();
        if ($action === 'create') $controller->create();
        else $controller->index();
        break;
    case 'reviews':
        $controller = new ReviewController();
        $product_id = $_GET['product_id'] ?? null;
        if ($action === 'create' && $product_id) $controller->create($product_id);
        elseif ($product_id) $controller->index($product_id);
        else echo "Prodotto non specificato.";
        break;
    case 'wishlist':
        $controller = new WishlistController();
        if ($action === 'add' && $id) $controller->add($id);
        elseif ($action === 'remove' && $id) $controller->remove($id);
        else $controller->index();
        break;
    case 'admin':
        $controller = new AdminController();
        if ($action === 'products') $controller->products();
        elseif ($action === 'orders') $controller->orders();
        elseif ($action === 'users') $controller->users();
        elseif ($action === 'export') $controller->export();
        elseif ($action === 'notification') $controller->notification();
        else $controller->dashboard();
        break;
    case 'api':
        $controller = new ApiController();
        if ($action === 'products') $controller->products();
        elseif ($action === 'orders') $controller->orders();
        elseif ($action === 'users') $controller->users();
        else $controller->products();
        break;
    case 'coupon':
        $controller = new CouponController();
        if ($action === 'apply' && isset($_POST['code'])) $controller->apply($_POST['code']);
        elseif ($action === 'remove') $controller->remove();
        break;
    case 'shipping':
        $controller = new ShippingController();
        if ($action === 'select' && $id) $controller->select($id);
        else $controller->index();
        break;
    case 'blog':
        $controller = new BlogController();
        if ($id) $controller->show($id);
        else $controller->index();
        break;
    case 'support':
        $controller = new SupportController();
        if ($action === 'faq') $controller->faq();
        elseif ($action === 'create') $controller->create();
        else $controller->index();
        break;
    case 'inventory':
        $controller = new InventoryController();
        if ($action === 'update' && $id && isset($_POST['quantity'])) $controller->update($id, $_POST['quantity']);
        else $controller->index();
        break;
    case 'activitylog':
        $controller = new ActivityLogController();
        $controller->index();
        break;
    case 'backup':
        $controller = new BackupController();
        if ($action === 'create') $controller->create();
        elseif ($action === 'download' && isset($_GET['filename'])) $controller->download($_GET['filename']);
        else $controller->index();
        break;
    case 'sociallogin':
        $controller = new SocialLoginController();
        if ($action === 'redirect' && isset($_GET['provider'])) $controller->redirect($_GET['provider']);
        elseif ($action === 'callback' && isset($_GET['provider'])) $controller->callback($_GET['provider']);
        else require __DIR__ . '/../views/users/sociallogin.php';
        break;
    case 'export':
        $controller = new ExportController();
        if ($action === 'productsCsv') $controller->productsCsv();
        elseif ($action === 'ordersCsv') $controller->ordersCsv();
        else require __DIR__ . '/../views/admin/export.php';
        break;
    case 'notification':
        $controller = new NotificationController();
        if ($action === 'orderConfirmation' && isset($_POST['user_email'], $_POST['order_id'], $_POST['total'])) {
            $controller->orderConfirmation($_POST['user_email'], $_POST['order_id'], $_POST['total']);
            echo "Email di conferma inviata!";
        } elseif ($action === 'supportReply' && isset($_POST['user_email'], $_POST['ticket_id'], $_POST['reply'])) {
            $controller->supportReply($_POST['user_email'], $_POST['ticket_id'], $_POST['reply']);
            echo "Email di risposta inviata!";
        } else {
            require __DIR__ . '/../views/admin/notifications.php';
        }
        break;
    default:
        $controller = new ProductController();
        $controller->index();
        break;
}
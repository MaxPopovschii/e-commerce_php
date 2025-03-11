require_once '../app/models/FAQ.php';
class FAQController {
    public function index() {
        $faqModel = new FAQ();
        $faqs = $faqModel->getAll();
        include '../app/views/faq_list.php';
    }
    public function create() {
        include '../app/views/faq_form.php';
    }
    public function store() {
        $faqModel = new FAQ();
        $faqModel->add($_POST['question'], $_POST['answer']);
        header('Location: /?controller=FAQ&action=index');
    }
}
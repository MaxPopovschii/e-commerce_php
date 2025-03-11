require_once '../app/core/Database.php';
class FAQ {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function getAll() {
        return $this->db->query("SELECT * FROM faq")->fetchAll();
    }
    public function add($question, $answer) {
        return $this->db->query("INSERT INTO faq (question, answer) VALUES (?, ?)", [$question, $answer]);
    }
}
 <?php
// Required namespace declarations
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

class PHP_Email_Form {
  public $to = '';
  public $from_name = '';
  public $from_email = '';
  public $subject = '';
  public $smtp = array();
  public $ajax = false;
  private $messages = array();

  public function add_message($content, $label, $priority = 0) {
    if (!empty($content)) {
      $this->messages[] = "$label: $content\n";
    }
  }

  public function send() {
    $message = implode("\n", $this->messages);
    $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
    $headers .= "Reply-To: {$this->from_email}\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    if (!empty($this->smtp)) {
      return $this->send_with_smtp($message);
    } else {
      return mail($this->to, $this->subject, $message, $headers) ? 'OK' : 'ERROR';
    }
  }

  private function send_with_smtp($message) {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host = $this->smtp['host'];
      $mail->SMTPAuth = true;
      $mail->Username = $this->smtp['username'];
      $mail->Password = $this->smtp['password'];
      $mail->SMTPSecure = $this->smtp['encryption']; // usually 'tls'
      $mail->Port = $this->smtp['port']; // usually 587

      $mail->setFrom($this->from_email, $this->from_name);
      $mail->addAddress($this->to);
      $mail->Subject = $this->subject;
      $mail->Body = $message;

      return $mail->send() ? 'OK' : 'ERROR: ' . $mail->ErrorInfo;
    } catch (Exception $e) {
      return 'ERROR: ' . $mail->ErrorInfo;
    }
  }
}
?>

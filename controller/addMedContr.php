<?php
class AddMedContr extends Controller
{
    private $name;
    private $addMedModel;
    private $price;
    private $amount;
    private $medURL;
    public function __construct($name, $price, $amount, $uploadedFile)
    {
        $this->addMedModel = new AddMedModel();
        $this->name = $name;
        $this->price = $price;
        $this->amount = $amount;
        $this->medURL = $this->processURL($uploadedFile);
    }
    public function processURL($uploadedFile)
    {
        $fileName = $uploadedFile['name'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $fileSize = $uploadedFile['size'];
        $fileError = $uploadedFile['error'];
        $fileType = $uploadedFile['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $this->fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = '../uploads/' . $this->fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                } else {
                    $_SESSION['err'] = "f";
                }
            } else {
                $_SESSION['err'] = "e";
            }
        } else {
            $_SESSION['err'] = "w";
        }
        return $this->fileNameNew;
    }
    public function getErrorsArr()
    {
        $errors = array();
        // form validation: ensure that the form is correctly filled
        // by adding (array_push()) corresponding error unto $errors array
        if (strlen($this->name) < 1) {
            array_push($errors, "Medicine name is required");
        }
        if (strlen($this->price) < 1) {
            array_push($errors, "Price is required");
        }
        if (strlen($this->amount) < 1) {
            array_push($errors, "Quantity is required");
        }
        $x = $this->addMedModel->isPharmMed($_SESSION['pharmacyID'], $this->name);
        echo $x;
        if (!($x == 0)) {
            echo $x;
            array_push($errors, "Medicine is already exists");
        }
        if (isset($_SESSION['err'])) {
            array_push($errors, $_SESSION['err']);
            unset($_SESSION['err']);
        }
        $_SESSION['errors'] = $errors;
        return $errors;
    }
    public function addMedicine()
    {
        $errCount = count($this->getErrorsArr());
        echo $errCount;
        if ($errCount == 0) {
            echo "fff";
            $medID = $this->addMedModel->getMedID($this->name);
            //echo $medID;
            if ($medID == 0) {
                $medID = $this->addMedModel->addMed($this->name);
            }
            $this->addMedModel->addPharmMed($medID, $_SESSION['pharmacyID'], $this->amount, $this->price, $this->medURL);
            if (!($this->amount == 0)) {
                $notify_det = $this->addMedModel->getNotifyAvailabilityDetails($medID);
                foreach ($notify_det as $notify_i) {
                    $pharm_det = $this->addMedModel->getPharmDet();
                    if ($notify_i['area'] == $pharm_det['area']) {
                        date_default_timezone_set('Asia/Colombo');
                        $date = date('m/d/Y h:i:s a', time());
                        $notification = $this->name . " is available now in " . $pharm_det['name'] . " - " . $pharm_det['area'];
                        $this->addMedModel->sendNotification($notify_i['customerID'], $notification, $date);
                        $this->addMedModel->setNotifyStatus($notify_i['customerID'], $notify_i['area'], $medID);
                    }
                }
                //header("Location: ../v.php");
                //exit();
            }
            unset($_SESSION['medname']);
            unset($_SESSION['price']);
            unset($_SESSION['amount']);
            unset($_SESSION['errors']);
            $_SESSION['successAdd'] = "successAdd";
        }
        //exit();
    }
}

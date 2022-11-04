<?php

class Orders 
{
    private $menueArray = array();
    private $orderArray = array();
    
    /**
     * index - Index-Seite des Order-Controllers. Brauchen wir aber nicht und leiten direkt auf die Startseite um
     *
     * @param  mixed $pagename
     *
     * @return void
     */
    public function index($pagename = 'Order - Placement / Index')
    {
        // Umleitung auf Startseite
        redirect('Home/index');
    }

    /**
     * add - Order Bestellung
     *
     * @param  mixed $pagename - Page Title
     *
     * @return void
     */
    public function add($pagename = 'Order - Add')
    {
        $orderModel = $this->model('OrderModel');
        $menueModel = $this->model('MenueModel');
        $menueArray = $menueModel->getFakeMenueDataArray();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process Form -> weil Post-Aufruf

            // Zuerst mal trimen und filtern auf gesunde Daten
            
            
            /* DEPRECATED
            $username = trim(
                filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)
            );
            $comment = trim(
                filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING)
            );
            */

            // Since 8.0
            $username = trim(htmlspecialchars($_POST['username']));
            $comment = trim(htmlspecialchars($_POST['comment']));

            $email = trim(
                filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)
            );
            $refmenue = trim(
                filter_input(INPUT_POST, 'refmenue', FILTER_SANITIZE_NUMBER_INT)
            );

            // Daten setzen
            $data = [
                'username' => $username,       // Form-Feld-Daten
                'username_err' => '',   // Feldermeldung für Attribute
                'email' => $email,          // Form-Feld-Daten
                'email_err' => '',      // Feldermeldung für Attribute
                'refmenue' => $refmenue,       // Form-Feld-Daten
                'refmenue_err' => '',   // Feldermeldung für Attribute
                'comment' => $comment       // Form-Feld-Daten
            ];


            // Gucken ob die Daten plausibel sind
            // Da müsste man aber noch mehr machen
            
            if(empty($data['username']))
            {
                $data['username_err'] = 'Bitte Name angeben';
            }

            if(empty($data['email']))
            {
                $data['email_err'] = 'Bitte Email angeben';
            }

            if(empty($data['refmenue']))
            {
                $data['refmenue_err'] = 'Bitte Menü auswählen';
            }

            // Keine Errors vorhanden
            if (empty($data['username_err']) && empty($data['email_err']) && empty($data['refmenue_err']))
            {
                // Alles gut, keine Fehler vorhanden
                // Späteres TODO: Auf DB schreiben

                $orderModel->fakewriteData($data);
            }
            else {
                // Fehler vorhanden - Fehler anzeigen
                // View laden mit Fehlern

                echo $this->twig->render('order/add.twig.html', ['title' => $pagename, 'urlroot' => URLROOT, 'data' => $data, 'menues' => $menueArray]);
            }

        } else {
            // Init Form mit Default-Daten, weil Get-Aufruf

            $data = [
                'username' => '',       // Form-Feld-Daten
                'username_err' => '',   // Feldermeldung für Attribute
                'email' => '',          // Form-Feld-Daten
                'email_err' => '',      // Feldermeldung für Attribute
                'refmenue' => '',       // Form-Feld-Daten
                'refmenue_err' => '',    // Feldermeldung für Attribute
                'comment' => ''       // Form-Feld-Daten
            ];

            echo $this->twig->render('order/add.twig.html', ['title' => "Order - Add", 'urlroot' => URLROOT, 'data' => $data, 'menues' => $menueArray]);
        }
    }

    /**
     * listmyorders - Liste nur meine Orders auf
     *
     * @param  mixed $pagename - Page Title
     *
     * @return void
     */
    public function listmyorders($pagename = 'Order - List my Orders')
    { 

        // Diese Var wird in Zukunft aus der Session kommen...so wie eingeloggt, so ist die Userid.
        // Da wir noch nichts von Usern wissen, faken(mocken) wir diese Infos
        $userid = 1;

        $orderModel = $this->model('OrderModel');
        $menueModel = $this->model('MenueModel');
        $menueArray = $menueModel->getFakeMenueDataArray();
        $orderArray = $orderModel->getFakeOrderDataForUserID($userid);

        // Fipseln uns einen Array zusammen, der dann gut auf der GUI funktioniert
        $data = $orderModel->renderOderList4GUI($orderArray, $menueArray);

        echo $this->twig->render('order/list.twig.html', ['title' => $pagename, 'urlroot' => URLROOT, 'data' => $data]);
    }
}

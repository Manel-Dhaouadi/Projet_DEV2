<?php
class Controller {

    protected function view($view, $data = []) {
        extract($data);

        // Inclut le header une seule fois
        require "../app/views/layout/header.php";

        // Inclut le contenu de la page
        require "../app/views/$view.php";

        // Inclut le footer une seule fois
        require "../app/views/layout/footer.php";
    }
}
<?php
class Admin {
    public function indexAction() {
        echo "test";
        AutoRender::render(array("a" => 123, "vvv" => 556));
    }
}
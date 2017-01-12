<?php
class Admin {
    public function indexAction() {
        AutoRender::render(array("a" => 123, "vvv" => 556));
    }
}
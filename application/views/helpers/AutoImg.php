<?php

class Zend_View_Helper_AutoImg extends Zend_View_Helper_HtmlElement {

    private $_attrs;

    public function autoImg($imgFile, $attrs = false) {
        if (empty($imgFile)) {
            $imgFile = 'nophoto.jpg';
        }
        if (null !== $attrs) {
            $_attrs = $this->_htmlAttribs($attrs);
        } else {
            $_attrs = '';
        }
        $tag = '<img src="' . $this->view->baseUrl('images/auto/' . $imgFile) . '" ' . $_attrs . '>';
        return $tag;
    }

}

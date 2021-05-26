<?php

class sitemap extends PHPFrodo {

    public function __contruct() {
        parent:: __construct();
    }
    public function welcome() {
        echo '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	    <head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    </head>
	    <body>
	';
        require_once 'SitemapGenerator.php';
        $sitemap = new SitemapGenerator("$this->baseUri/");
        $this->select()
                ->from('item')
                ->join('sub', 'item_sub = sub_id', 'LEFT')
                ->join('categoria', 'item_categoria = categoria_id', 'LEFT')
                ->where("item_estoque > 0")
                ->groupby('item_id')
                ->orderby("item_pos ASC")
                ->execute();
        if ($this->result()) {
            $list = $this->data;
            $sitemap->addUrl("$this->baseUri/", date('c'), 'daily', '1');
            foreach ($list as $item) {
                $i = (object) $item;
                $sitemap->addUrl("$this->baseUri/produto/$i->categoria_url/$i->sub_url/$i->item_url/$i->item_id/", date('c'), 'daily', '0.5');
            }
        }
        // create sitemap
        $sitemap->createSitemap();
        // write sitemap as file
        $sitemap->writeSitemap();
        // update robots.txt file
        $sitemap->updateRobots();
        // submit sitemaps to search engines
        $sitemap->submitSitemap();
        echo '</body></html>';
        $this->redirect("$this->baseUri/sitemap.xml");
    }

}

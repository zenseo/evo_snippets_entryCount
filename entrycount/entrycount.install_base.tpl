//<?php
/**
 * entryCount
 *
 * 指定フォルダ配下の公開記事件数を数えます。
 * 
 * @category	snippet
 * @version 	1.0.1
 * @internal	@properties &parentId=parent;string;&depth=depth;string;&isFolder;is target folder;string;
 * @internal    @installset base
 * @author  	t.nishioka
 */
//スニペットで指定するパラメーター
$arrParams = array(
 'parentID' => (isset($parentId)) ? $parentId : $modx->documentIdentifier,
 'isFolder' => (isset($isFolder)) ? $isFolder : 0,
 'depth' => (isset($depth)) ? $depth : 3
);

include_once($modx->config['base_path'] . 'assets/snippets/entrycount/entrycount.class.inc.php');
$objEntryCount = new entryCount();
$ret = $objEntryCount->getEntryCount($arrParams);
unset($objEntryCount);

return $ret;

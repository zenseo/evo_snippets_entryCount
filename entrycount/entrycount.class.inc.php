<?php
/*
 entryCount

 Author:t.nishioka
 Version:1.0.0
 LastUpdate:2013.06.12 

*/
class entryCount
{
	function entryCount()
	{
		//既定
		$this->fields = 'id';
		$this->where = '';
		$this->where_r = 'isFolder = 1';
		$this->count = 0;
		$this->endLevel = 1; //
	}
	

	function getEntryCount($arrParams)
	{
		global $modx;


		/*パラメータは配列で引き渡され、以下の変数に格納される
		$parentID	:調査対象id
		$depth		:階層
		$idFolder	:フォルダ除外フラグ
		*/
		if(is_array($arrParams)){
			foreach( $arrParams as $key => $value){ $$key = $value; }
		}else{
			return $this->count;
		}

		//検索条件
		$this->where = ($isFolder==0) ? 'isFolder =' . $isFolder :''; //フォルダはデフォで除外

		//件数カウント用
		$arrChildren = $modx->getDocumentChildren($parentID, 1, 0, $this->fields, $this->where);

		//再帰探索用サブフォルダのみの配列
		$arrSubFolders = $modx->getDocumentChildren($parentID, 1, 0, $this->fields, $this->where_r);

		//再帰処理中止判断 *endLevelは常に1
		if($this->endLevel >= $depth){
			return count($arrChildren); 
		}else{

			if(count($arrSubFolders) > 0){
				
				foreach($arrSubFolders as $item){
					$arrNextParms = array(
						'parentID'	=> $item['id'],
						'isFolder'	=> $isFolder,
						'depth'		=> $depth-1 //再帰では探索数を引き算
					);
				
					$this->count += $this->getEntryCount($arrNextParms); //再帰的に加算
				
				}
				
			}else{ //サブフォルダがなければ終了
				return count($arrChildren); 
			}

		}
		
		//これは基本的に不要
		return $this->count; 
		
	}

//API書式参考
//getDocumentChildren($parentid= 0, $published= 1, $deleted= 0, $fields= '*', $where= '', $sort= 'menuindex', $dir= 'ASC', $limit= '')
//$whereは既定にANDで追加する仕様。

}

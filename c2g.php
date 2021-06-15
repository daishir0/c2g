<?php
  //////////////////////////////////////////////
  /**
   * ColladaファイルをglTFファイルに変換するWebプロキシ
   */
  //////////////////////////////////////////////

  /////////////////////////////////////
  //定数定義
  define("COLLADA_DIR" , "/var/www/data/c2g.php/collada");          //変換元 Collada用ディレクトリ
  define("GLTF_DIR"    , "/var/www/data/c2g.php/collada/output");   //変換先 glTF用ディレクトリ
  define("VALID_DOMAIN", "https://");                               //Collada取得先のドメイン名を指定

  /////////////////////////////////////
  //Get引数 u のバリデーションチェック
  $url = $_GET['u'];
  if(                                       //以下の条件に当てはまると処理停止する
    (isset($url) == false)or                //変数がセットされていない場合
    ($url == "")or                          //変数が空の場合
    (strpos($url, '.dae') === false)or      //変数に.daeが含まれない場合
    (strpos($url, VALID_DOMAIN) === false)  //変数に対象ドメイン名が含まれない場合
  ){
    return;                                 //処理停止する
  }

  //////////////////////////////////////////////
  //Get引数 refresh のバリデーションチェック
  $refresh = $_GET['refresh'];
  if(isset($refresh) == true && $refresh = 1)
  {
    $force_refresh = true;   //強制リフレッシュフラグ設定
  }
  
  /////////////////////////////////////
  //Collada, gtTFファイル名作成
  $collada_filename_sha1 = basename($url) . "_" . sha1($url);                        //一意なColladaファイル名作成
  $gtlf_filename_sha1 = str_replace('.dae', '.gltf', $collada_filename_sha1);        //一意なglTFファイル名作成
  $gltf_filename = substr($gtlf_filename_sha1 ,0 ,strlen($gtlf_filename_sha1) - 41); //glTFファイル名

  /////////////////////////////////////
  //変換済のglTFファイルがある場合は、そのまま返す（キャッシュ処理）
  if (file_exists(GLTF_DIR . "/" . $gtlf_filename_sha1) && !$force_refresh) {
    header('Content-Type: model/gltf+json');
    header("Content-Disposition: attachment; filename=$gltf_filename"); 
    readfile(GLTF_DIR . "/" . $gtlf_filename_sha1);
    return;
  }

  /////////////////////////////////////
  //Colladaファイルのダウンロード処理
  $collada_data = file_get_contents($url);                                  //$urlからColladaファイル取得
  file_put_contents(COLLADA_DIR."/".$collada_filename_sha1, $collada_data); //Colladaファイルの保存

  /////////////////////////////////////
  //Colladaファイルの変換処理
  $cmd = "/home/ec2-user/COLLADA2GLTF/build/COLLADA2GLTF-bin"    //Colladaファイル変換コマンド
  . " -i " . COLLADA_DIR . "/" . $collada_filename_sha1          //変換元Colladaファイル
  . " -o " . GLTF_DIR . "/" . $gtlf_filename_sha1;               //変換先glTFファイル
  exec($cmd, $output);                                           //実行
  //var_dump($output);// 結果出力

  /////////////////////////////////////
  //変換済のglTFファイルを返す
  header('Content-Type: model/gltf+json');
  header("Content-Disposition: attachment; filename=$gltf_filename"); 
  readfile(GLTF_DIR . "/" . $gtlf_filename_sha1);
  return;

# c2g - Collada2glTF Webプロキシ  
Collada2glTFを用いた、Web版のCollada2glTFコンバーターです。  
透過的プロキシとして利用可能です。  

## 使い方  
対象のColladaファイルが配置されているURLの頭に「https://(your-domain)/c2g.php?u=」を付与すると、glTF形式のデータに変換されます。  

例）  
https://(your-domain)/c2g.php?u=(Collada File URL)  
※ソース内でVALID_DOMAINにて指定されたドメイン（FQDN）のURLに限ります。

## CDN機能  
1度アクセスをするとColladaファイルはキャッシュされます。強制的にキャッシュをクリアしたい場合はGETパラメータにてrefresh=1を付与してください。

例）  
https://(your-domain)/c2g.php?u=(Collada File URL)&refresh=1  


## 謝辞  
当ソフトウェアはCollada2glTFを用いています。有益なソフトウェアを提供頂き、コミュニティの皆さま、ありがとうございます。
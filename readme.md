# c2g - Collada2glTF Web Proxy
A web-based Collada2glTF converter using Collada2glTF.  
It can be used as a transparent proxy.

## Usage
Add "https://(your-domain)/c2g.php?u=" to the beginning of the URL where the target Collada file is located, and it will be converted to glTF format.

Example)
https://(your-domain)/c2g.php?u=(Collada File URL)
*Only URLs of domains (FQDNs) specified by VALID_DOMAIN in the source code are allowed.

## CDN function
Once accessed, the Collada file will be cached. If you want to clear the cache forcibly, add refresh=1 as a GET parameter.

Example)
https://(your-domain)/c2g.php?u=(Collada File URL)&refresh=1


## Acknowledgments
This software uses Collada2glTF. Thank you to the community for providing us with useful software.

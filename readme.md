# Firebase CMS

The point of this repository is to create a basic engine with which one can consume either structural configurations to generate websites on the fly based on templates, consume content data to populate a basic website with content from firebase, or both.

The goal is for users to be able to drop the `/src/api/` contents in the root of the directory where they want the website and start creating templates in the `templates` folder. All of the site configurations will be described in the `/src/api/configs/firebaseCms.json`. 

## Firebase CMS Config

** Properties **

`baseUrl`: a string that defines the base url to be considered for your website. This examples lives at `domain.com/firebase-test/src/api/`, so `/firebase-test/src/api/` would be the value.

`content`: boolean value if firebase holds content data for the website.

`firebaseStartingRoot`: a string details what node the cms will look for data. Below is an example.

Typically users will want to store the website information in a child node in firebase. Firebase CMS supports this by allowing the user to indicate where there information starts.  Consider the following firebase structure for the website Wookies Selling Banannas.

```
/
-> adminConfig
    -> ...
-> websites
    -> wookiesSellingBanannas
        -> siteData
            -> structure
                -> ...
            -> content
                -> ...
```

The data for the website doesn't start until `websites/wookiesSellingBanannas/`, so this would be the string

`structure`: boolean value if firebase holds structure data for the website.


# docker-wordpress

## Dockerfile.onbuild example

Using `FROM gcr.io/raelga/wordpress:latest` will:

- Copy `wp-content` from the docker context to `/var/www/html/wp-content`
- Copy `plugins.list` from the docker context to `/var/www/html/wp-content/plugins/plugins.list`
- Read the file `/var/www/html/wp-content/plugins/plugins.list` and download all the plugins listed

```
$ docker build -t example-wp -f Dockerfile context/
Sending build context to Docker daemon  3.936MB
Step 1/1 : FROM gcr.io/raelga/wordpress:latest
latest: Pulling from raelga/wordpress
27833a3ba0a5: Already exists 
2d79f6773a3c: Already exists 
f5dd9a448b82: Already exists 
95719e57e42b: Already exists 
cc75e951030f: Already exists 
78873f480bce: Already exists 
1b14116a29a2: Already exists 
ea69a25cac2e: Already exists 
2dbd1202c78e: Already exists 
22cefd01eafa: Already exists 
21da110f3a63: Already exists 
0c1e476df271: Already exists 
70a74d14ca92: Already exists 
6590e4467d09: Already exists 
1b0635fe52ca: Already exists 
ccb00f7ad0b4: Already exists 
996d17ef73fc: Already exists 
2aa80255fade: Already exists 
6a6dca4d800a: Already exists 
1674e86caa8e: Pull complete 
Digest: sha256:e010adc7d5789b75e86e2799bb08e7baec225750d6dce34ef14be2b4ae507d85
Status: Downloaded newer image for gcr.io/raelga/wordpress:latest
# Executing 3 build triggers
 ---> Running in bdd18a2ac418
######################################################################## 100.0%
Plugin raelga/wp-mailgun:1.7.1 downloaded.
######################################################################## 100.0%
Plugin wpCloud/wp-stateless:2.2.6 downloaded.
######################################################################## 100.0%
Plugin WP2Static/wp2static:6.6.5 downloaded.
Removing intermediate container bdd18a2ac418
 ---> 3b0c87eb6eb5
Successfully built 3b0c87eb6eb5
Successfully tagged example-wp:latest
```

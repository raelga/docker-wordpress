# docker-wordpress
Dockerfile for Wordpress with some plugin/theme management

## Dockerfile

### Stage: wp-plugins

Downloads form GitHub the plugins listed in [context/plugins.list](context/plugins.list):

```
raelga/wp-mailgun:1.7.1
wpCloud/wp-stateless:2.2.6
WP2Static/wp2static:6.6.5
```

The format is: `<github-username>/<github-repo>:<github-tag>`.

### Stage: wp

- Copies the content from [context/wp-content](context/wp-content)
- Copies the plugins from the `wp-plugins` stage to the wp plugins folder.
- Adds some php optimizations

### Output

```bash
docker build -t cms.bigot.es:7c4311f -f cms.bigot.es/Dockerfile cms.bigot.es/context
Sending build context to Docker daemon  3.936MB
Step 1/7 : FROM bash:5.0 as wp-plugins
 ---> f63c4bf22009
Step 2/7 : ADD plugins.list /tmp/wp-plugins/plugins.list
 ---> 263f808fe293
Step 3/7 : RUN while read plugin || [ -n "$plugin" ]; do     wget -q -O - https://github.com/${plugin/\:*/}/archive/${plugin/*:/}.tar.gz     | tar zx -C /tmp/wp-plugins     && echo "Plugin ${plugin} downloaded.";     done < /tmp/wp-plugins/plugins.list
 ---> Running in f5217e97b99c
Plugin raelga/wp-mailgun:1.7.1 downloaded.
Plugin wpCloud/wp-stateless:2.2.6 downloaded.
Plugin WP2Static/wp2static:6.6.5 downloaded.
Removing intermediate container f5217e97b99c
 ---> a639b006aec8
Step 4/7 : FROM wordpress:5.1
 ---> d3a744e0e523
Step 5/7 : COPY --chown=www-data wp-content /var/www/html/wp-content
 ---> Using cache
 ---> 3649a2f4204b
Step 6/7 : COPY --from=wp-plugins --chown=www-data /tmp/wp-plugins /var/www/html/wp-content/plugins/
 ---> 24191ed6bb75
Step 7/7 : RUN { mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini;               echo 'opcache.memory_consumption=64';           echo 'opcache.max_accelerated_files=4000';              echo 'opcache.revalidate_freq=10';      } > /usr/local/etc/php/conf.d/opcache-recommended.ini
 ---> Running in d1f3bd26f718
Removing intermediate container d1f3bd26f718
 ---> e86ce9bed1cc
Successfully built e86ce9bed1cc
Successfully tagged cms.bigot.es:7c4311f
```

## Dockerfile.onbuild

The `Dockerfile.onbuild` builds the `gcr.io/raelga/wordpress:latest` image with some ONBUILD triggers, to copy the wp-context and download the plugins from the `plugins.list` on build when used as `FROM`.

```
$ cat Dockerfile 
FROM gcr.io/raelga/wordpress:latest
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

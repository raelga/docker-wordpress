# docker-wordpress
Dockerfile for Wordpress with some plugin/theme management

## Build

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

## Output

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

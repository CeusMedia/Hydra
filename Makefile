USER	:= kriss
GROUP	:= www-data

install:
	@test ! -f vendor/autoload.php && composer install || true
	@test -f config/instances.json && rm config/instances.json || true
	@cp config/instances.json.dist config/instances.json
	@test -f config/modules/sources.json && rm config/modules/sources.json || true
	@cp config/modules/sources.json.dist config/modules/sources.json
	@sudo chgrp -R ${GROUP} .
	

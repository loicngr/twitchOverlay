FOLDER_BACK=./back
FOLDER_FRONT=./front
APP_NAME=twitchOverlay

########################################
################ COMMON ################
########################################
check:
	@make front-fixer && \
	make back-fixer

#########################################
################ BACKEND ################
#########################################
back-fixer:
	@cd $(FOLDER_BACK) && \
	./vendor/bin/php-cs-fixer fix src --show-progress=dots

back-reset:
	@cd $(FOLDER_BACK) && \
	bin/console d:d:d --force && \
	bin/console d:d:c && \
	bin/console d:m:m --no-interaction && \
	cd .. && \
	make back-load-fixtures

back-load-fixtures:
	@cd $(FOLDER_BACK) && bin/console d:f:load

back-serve:
	@cd $(FOLDER_BACK) && symfony serve --no-tls

##########################################
################ FRONTEND ################
##########################################
front-fixer:
	cd $(FOLDER_FRONT) && \
	npm run lint -- --fix

front-serve:
	cd $(FOLDER_FRONT) && \
	npm run dev

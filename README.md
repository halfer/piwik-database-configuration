Piwik Database Configuration plugin
===

This repo is a simple plugin for the Piwik web analytics package to set database credentials
based on environment variables. This is great for containerisation, since it means that one
container image is good for all environments.

Installation
---

To start with I empty the settings in `config.ini.php`, to ensure that connection information
only comes through environment variables:

	; file automatically generated or modified by Piwik; you can manually override the default values in global.ini.php by redefining them in this file.
	[database]
	host = ""
	username = ""
	password = ""
	dbname = ""

Next, copy the `DatabaseConfiguration.php` file into `plugins/DatabaseConfiguration/DatabaseConfiguration.php` in the Piwik project.

Finally, there are two configuration changes to be made:

1. Add the following to `config.ini.php`. If you are Dockerising you will probably have a full copy of
this file in your repo:

        [PluginsInstalled]
        PluginsInstalled[] = "DatabaseConfiguration"

(You don't need to add `[PluginsInstalled]` if you add this into the existing section of that name,
of course).

2. Add the following to the end of the `[Plugins]` section in your `global.ini.php`. If you are
Dockerising, you will need a script to insert the additional line in the right block; it is not
sufficient to merely append it.

        Plugins[] = DatabaseConfiguration

Running
---

Environment variables can be supplied in a variety of ways, the instructions here will focus on
Docker. Docker allows variables to be supplied in a file, like so:

	# Saved as config/envs/local in the Docker repo
	PIWIK_DATABASE_HOST=docker
	PIWIK_DATABASE_NAME=piwik
	PIWIK_DATABASE_USER=piwik
	PIWIK_DATABASE_PASSWORD=password

We can then launch the Piwik container using something like this (note the use of the `env-file`
here):

	docker run \
		-p 127.0.0.1:9999:80 \
		--add-host=docker:${DOCKER_HOSTIP} \
		--env-file=config/envs/local \
		piwik

Notes
---

At some point I hope to publish a repo showing how I have set up Piwik in Docker. Note that there
is [an official repo](https://github.com/piwik/docker-piwik) to Dockerise Piwik, but I didn't
want to move my database to a container, nor to be forced to containerise my web server.

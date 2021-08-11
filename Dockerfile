# this is a development container, not hardened for hosting
FROM php:7.4-cli
RUN apt-get update && \
	apt-get install -y \
		sqlite \
		unzip

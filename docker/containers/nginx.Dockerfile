FROM debian:latest
MAINTAINER Tyler Mulligan <z@xnz.me>

RUN apt-get update; \
	apt-get install -y nginx php5-fpm php5-cli php5-mcrypt php5-mysql git curl mysql-client; \
	apt-get clean; apt-get autoclean

RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0;/" /etc/php5/fpm/php.ini && \
    php5enmod mcrypt && \
    service php5-fpm restart

COPY nginx/tmm.8ed.local.conf /etc/nginx/sites-enabled/

RUN service nginx stop && \
    echo "daemon off;" >> /etc/nginx/nginx.conf && \
    rm /etc/nginx/sites-enabled/default && \
    mv /etc/nginx/sites-enabled/tmm.8ed.local.conf /etc/nginx/sites-enabled/default

COPY bin/wait-for-mysql.sh /bin/wait-for-mysql.sh
RUN chmod +x /bin/wait-for-mysql.sh

EXPOSE 80 443

CMD /bin/wait-for-mysql.sh
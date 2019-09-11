FROM orsolin/docker-php-5.3-apache

LABEL Author="glzjin <i@zhaoj.in>" Blog="https://www.zhaoj.in"

COPY ./files /tmp/files

RUN mv -f /tmp/files/sources.list /etc/apt/sources.list \
    && rm -rf /var/www/html/* \
    && mv -f /tmp/files/init.sql /tmp/db.sql \
    && mv -f /tmp/files/html/* /var/www/html/ \
    && apt update \
    && echo "debconf mysql-server/root_password password root\ndebconf mysql-server/root_password_again password root" >> /tmp/mysql-passwd \
    && debconf-set-selections /tmp/mysql-passwd && apt install mysql-server -y && rm -rf /tmp/mysql-passwd \
    && mysql_install_db --user=mysql --datadir=/var/lib/mysql \
    && sh -c 'mysqld_safe &' \
    && sleep 5s \
    && mysql -e "source /tmp/db.sql;" -uroot -proot \
    && echo "magic_quotes_gpc = Off\nopen_basedir = /var/www/html/:/tmp/:/proc/\ndisable_functions = pcntl_alarm,pcntl_fork,pcntl_waitpid,pcntl_wait,pcntl_wifexited,pcntl_wifstopped,pcntl_wifsignaled,ini_set,pcntl_wifcontinued,pcntl_wexitstatus,pcntl_wtermsig,pcntl_wstopsig,pcntl_signal,pcntl_signal_get_handler,pcntl_signal_dispatch,pcntl_get_last_error,pcntl_strerror,pcntl_sigprocmask,pcntl_sigwaitinfo,pcntl_sigtimedwait,pcntl_exec,pcntl_getpriority,pcntl_setpriority,pcntl_async_signals,system,exec,shell_exec,popen,proc_open,passthru,symlink,link,syslog,imap_open,dl,mail	" >> /etc/php5/apache2/php.ini && \
    touch /flag && \
    mv /tmp/files/readflag /readflag && \
    chmod 555 /readflag && \
    chmod u+s /readflag && \
    chmod 500 /flag

WORKDIR /var/www/html/

CMD echo $FLAG >> /flag && export FLAG=not_flag && FLAG=not_flag && find /var/lib/mysql -type f -exec touch {} \; && service mysql start && apache2-foreground

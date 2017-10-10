FROM centos:7
RUN \
    yum update -y && \
    yum install httpd -y && \
    yum install perl -y && \
    yum install gcc -y && \
    yum install perl-DBD-MySQL -y && \
    yum install perl-XML-Parser.x86_64 -y && \
    yum install perl-XML-Simple.noarch -y && \
    yum install cpanminus -y && \
    cpanm CGI && \
    #cpanm Redis::hiredis && \
    cpanm Plack::Loader && \
    cpanm Bread::Board && \
    cpanm DBIx::Class::Schema && \
    cpanm Router::Simple && \
    cpanm -f Form::Sensible && \
    cpanm DBIx::Class::Schema::Loader
    #&& \cpanm Amazon::SQS::Simple

#run cpanm -f Lingua::PT::Inflect
#run cpanm -f SQL::Translator

COPY httpd.conf /etc/httpd/conf/


CMD ["/usr/sbin/httpd","-DFOREGROUND"]

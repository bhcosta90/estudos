#!/usr/bin/perl
use strict;
use warnings FATAL => 'all';
no warnings;

use CGI::Carp qw(fatalsToBrowser set_message);
use Router::Simple;

BEGIN {
    set_message(sub {
        my $error = shift;
        print "<p>$error</p>";
    });
}

my $router = Router::Simple->new();
$router->connect('/', {controller => 'Root', action => 'show'});
$router->connect('/blog/{year}/{month}', {controller => 'Blog', action => 'monthly'});

my $app = sub {
    my $env = shift;
    if (my $p = $router->match($env)) {
        # $p = { controller => 'Blog', action => 'monthly', ... }
    } else {
        [404, [], ['not found']];
    }
};

print 1;

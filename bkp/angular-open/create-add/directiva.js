function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

angular.module('BRCas.directive', []).directive('adicionar', function(){
    return {
        restrict: 'A',
        require: '^ngModel',
        scope: {
            ngModel: "=",
            ngAtualizar : "="
        },
        link: function(scope,element,attrs){
            element.bind('click',function(){
                var total = Math.floor((Math.random() * 100000) + 1) + new Date().getTime();
                var funcao = (attrs.adicionar.split("?").length > 1 ? "&" : "?") + "funcao=" + total;

                var iframe = $("<iframe>", {
                    "src" : attrs.adicionar + funcao
                });

                if(eval("window.atualizar_"+total) === undefined){
                    var funcao = function(data){
                        scope.$apply(function(){
                            if(typeof scope.ngModel == 'object' ){
                                scope.ngModel.push(data);
                                if(attrs.ngAtualizar !== undefined){
                                    scope.ngAtualizar = data;
                                }
                            }else{
                                scope.ngModel = data;
                            }

                            iframe.remove();
                        });
                    };

                    eval("window.atualizar_"+total+" = " + funcao);
                };

                $('body').append(iframe);
            })
        }
    };
}).run(function($rootScope) {
    $rootScope.salvar = function(url, dados, method='POST') {
        if(url===undefined){
            alert('First parameter have that be past');
            return;
        }
        if(dados===undefined){
            alert('Second parameter have that be past');
            return;
        }

        eval("window.parent.atualizar_"+getParameterByName('funcao')+"(dados)");
    };
});

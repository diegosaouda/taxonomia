var app = angular.module('Taxonomia',['ngRoute', 'ngResource']);

app.config(function($routeProvider) {

	$routeProvider.when('/code', {
            templateUrl: 'app/view/code.tpl.html',
            controller: 'CodeController'   
	});
        
        $routeProvider.when('/list', {
            templateUrl: 'app/view/list.tpl.html',
            controller: 'ListController'   
	});
        
        $routeProvider.when('/not-found', {
            templateUrl: 'app/view/not-found.tpl.html'
	});
	
	$routeProvider.otherwise({redirectTo: '/not-found'});
	
});
app.controller('CodeController', function($scope, $http) {

    $scope.taxonomia = {};

    $scope.getCode = function() {
        
        if ($scope.codeTaxonomia === undefined || $scope.codeTaxonomia === '') {
            return ;
        }
        
        $http.get('/api.php/code/' + $scope.codeTaxonomia)
            .success(function(data) {
                $scope.taxonomia = data;
            }).error(function() {
                alert('Ocorreu um erro');
            });
            
    };
    

    
});
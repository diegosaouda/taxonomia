app.controller('ListController', function($scope, $http) {
    
    /**
     * Inserir taxonomia
     * @param {String} tipoTaxonomia
     * */
    $scope.inserirTaxonomia = function(tipoTaxonomia) {
        if (tipoTaxonomia === undefined) {
            alert('Selecione um tipo de taxonomia');
            return ;
        }
        
        if (confirm('Tem certeza que deseja inserir essa taxonomia ?')) {
            
        }
        
    };
    
    $scope.getLista = function(buscar) {
        if (buscar === undefined || buscar === '') {
            return ;
        }
        
        $http.get('/api.php/busca/' + buscar)
            .success(function(data) {
                
                $scope.taxonomias = data;
                
            }).error(function() {
                alert('Ocorreu um erro');
            });
            
    };
    

    
});
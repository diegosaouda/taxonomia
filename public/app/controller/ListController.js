app.controller('ListController', function($scope, $http) {
    
	$scope.tipoTaxonomia = 'todas';
	$scope.resultInsert = null;
	
    /**
     * Inserir taxonomia
     * @param {String} tipoTaxonomia
     * */
    $scope.inserirTaxonomia = function(descricao, tipoTaxonomia, tela) {
        if (tipoTaxonomia === 'todas') {
            alert('Selecione um tipo de taxonomia diferente de "todas"');
            return ;
        }
        
        if (confirm('Tem certeza que deseja inserir essa taxonomia ?')) {
			var url = '/api.php/inserir';
			var data = {
				nm_taxonomia: tipoTaxonomia,
				nm_descricao: descricao,
				nm_pagina: tela
			};
			
			$http.post(url, data)
				.success(function(result){
					$scope.resultInsert = result;
				
				}).error(function() {
					alert('Ocorreu um erro');
				});
        }
        
    };
    
    $scope.getLista = function(buscar, tipo) {
		$scope.resultInsert = null; //zerando a variavel
		
        if (buscar === undefined || buscar === '') {
            return ;
        }
        
		var url = '/api.php/busca/:busca/:tipo'
			.replace(':busca',buscar)
			.replace(':tipo',tipo);
		
        $http.get(url)
            .success(function(data) {
                $scope.taxonomias = data;
                
            }).error(function() {
                alert('Ocorreu um erro');
            });
            
    };
    

    
});
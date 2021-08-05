$(document).ready(function(){
    document.getElementById('search').onkeydown = function(e){
        if(e.keyCode == 13){
            $("#searchForm").submit();
        }
     };
});
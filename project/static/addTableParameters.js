var allThElements =  document.getElementsByTagName("th");
console.log(allThElements.length);
for(var i = 0; i < allThElements.length; i++){
    console.log("i");
    allThElements[i].setAttribute("id",i);
    allThElements[i].style.cursor = "pointer"
    allThElements[i].addEventListener("click", function() {
        sortTable(this.id);
    });
}
for(var j = 0; j < document.getElementsByTagName("table").length;j++){
    var id = "table"+j;
    document.getElementsByTagName("table")[j].setAttribute("id",id);

}

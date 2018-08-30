
   // function say(){
   //   var ob1= new XMLHttpRequest();
   //   var name=document.getElementById('ser').value; 
     
      
   //    ob1.onreadystatechange=function(){   
   //      if (ob1.readyState==4 && ob1.status==200) {    
   //    document.getElementById("tbl").innerHTML= ob1.responseText; 
   
   //    }}
      
   //    ob1.open("POST","shop1.php?do=Manageitem",true);
   //    ob1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   //    ob1.send("&N="+name);
     
   // }



$("button").click(function(){


   var name= $("#name").val();
   // var phone= $("#phone").val();
 $.ajax({
         
         url:"shop1.php?do=Manage",
          type:"POST",
         data:{
            n:name,
           
         },
         success:function(data){
           $("#tbl").html(data)
             $("#name").val("");
         }
  

 })

});

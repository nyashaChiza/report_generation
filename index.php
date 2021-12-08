<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title></title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
     
   </head>
   <body>
   <br>
      <div class='text-header bg-light text-center col-md-12 mx-auto'>
	  <span class = 'h2 text-center  mx-auto'> ZIMRA P2 FORM</span>
	  </div>
	  <br><br>
        <div class="col-md-8 mx-auto bg-light" >
		<br>
        <form action = 'process.php' method = 'POST'>
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="text" required name='ename' class="form-control" id="floatingInput" placeholder="1. Employer's Name">
            <label for="floatingInput">1. Employer's Name</label>
          </div>
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="text" required name='tname'  class="form-control" id="floatingPassword" placeholder="Trade Name">
            <label for="floatingPassword">2. Trade Name</label>
          </div>
		  
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="number" required name='btnumber' class="form-control" id="floatingInput" placeholder="BusinessPartner Number">
            <label for="floatingInput">3. BusinessPartner Number</label>
          </div>
		  <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="number" required name='paye'  class="form-control" id="floatingInput" placeholder="PAYE Number">
            <label for="floatingInput">4. PAYE Number</label>
          </div>
		  
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="text" required name = 'tin' class="form-control" id="floatingPassword" placeholder="TIN ">
            <label for="floatingPassword">5. TIN </label>
          </div>
         
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="text" required name= 'address' class="form-control" id="floatingInput" placeholder="Physical Address">
            <label for="floatingInput">6. Physical Address</label>
          </div>
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="text" required name = 'postal' class="form-control" id="floatingPassword" placeholder=" Postal Address">
            <label for="floatingPassword">7. Postal Address</label>
          </div>
		  
		  <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="date" required name = 'tax_period' class="form-control" id="floatingInput" placeholder="Tax Period">
            <label for="floatingInput">8. Tax Period</label>
          </div>
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="date" required name = 'due_date' class="form-control" id="floatingPassword" placeholder="Due Date">
            <label for="floatingPassword">9. Due Date</label>
          </div>
		  
		  <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="email" required name = 'email' class="form-control" id="floatingInput" placeholder="E-mail address">
            <label for="floatingInput">10. E-mail address</label>
          </div>
          <div class="form-floating col-md-10 mx-auto mb-3">
            <input type="tel" required name= 'cell' class="form-control" id="floatingPassword" placeholder="Cell number">
            <label for="floatingPassword">11. Cell number</label>
          </div>
		  
		   <div class="form-floating col-md-10 mx-auto mb-3">
            <button type="submit" class="btn btn-primary">Download Report</button>
          </div>
		  
        </form>
		<br>
        </div>
     

    <script src="" async defer></script>
   </body>
</html>
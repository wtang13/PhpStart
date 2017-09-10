<div class="UserInfo">
    <form class="table">
        <div class="form-group">
            <label for="name"> Name</label>
            <input type="text" class="from-control" id="name" name="name">
        </div>
        
        <div class ="form-group">
            <label for="age">Age</label>
            <input type="text" class="from-control" id="age" name="age">
        </div>
        
        <div class="from-group">
            <label for="gender">Gender</label>
            <input type="text" class="from-control" id="gender" name="gender">
        </div>
        
        <div class="from-group">
            <label for="occupation"> Occupation</label>
            <input type="text" class="from-control" id="occupation" name="occupation">
        </div>       
        <button type="submit" class="btn s" > Submit</button>
        </form>
    <form class = "print" action ="../app/doPrint.php" method ="GET">
        <p>To verify, please input your name</p>
        <label for="name"> Name</label>
        <input type="text" class="toprint" id="name" name="name">
        <button class="btn p"> PrintPDF</button>
    </form>
</div>
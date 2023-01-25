<?php 

    $page_title = 'List of Users';
    require_once 'init.php';

    $db = new Database();
    $pagination = new Pagination();
    $user = new User();
    $data = $pagination->showDataPaging();

    if(isset($_POST['search'])){
    
        $data = $user->searchUser(); 
    
    }

?>

        <div class="container">

            <h2 class="mt-5">List of Users</h2>

            <div class="mt-3 mr-3" style="width:524px;">
                
                <?php Flasher::flash(); ?>

            </div>

            <form action="" method="post">   

                <div class="row col-lg-6 float-left">
                
                    <div class="input-group mt-3 mb-3"> 
                    
                        <input type="text" name="keyword" class="form-control" placeholder="Search something..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    
                        <div class="input-group-append">
                                
                            <button type="submit" class="btn btn-primary" name="search" type="button" id="button-addon2">Search</button>
                        
                        </div>
                        
                    </div>
                
                </div>
            
            </form>

            <div class="row mt-3 mr-1 float-right">
            
                <a class="btn btn-primary" href="add.php">Add User</a>

            </div>

            <table class="table table-bordered table-hover mt-3">
        
                <thead>
                    
                    <tr>
                    
                        <th>No</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Instagram</th>
                        <th>Email</th>
                        <th>Actions</th>
            
                    </tr>
        
                </thead>
        
                <tbody>
        
                    <?php $no = $pagination->startData + 1; ?>
        
                    <?php foreach($data as $d) : ?>
                    
                    <tr>
                
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['fullname']; ?></php></td>
                        <td><?php echo $d['phone']; ?></php></td>
                        <td><?php echo $d['instagram']; ?></php></td>
                        <td><?php echo $d['email']; ?></php></td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="read.php?id=<?php echo $d['id']; ?>">Read</a>
                            <a class="btn btn-outline-success btn-sm" href="edit.php?id=<?php echo $d['id']; ?>">Edit</a>
                            <a class="btn btn-outline-danger btn-sm" href="delete.php?id=<?php echo $d['id']; ?>">Delete</a>
                        </td>
                    
                    </tr>
        
                    <?php endforeach; ?>
        
                </tbody>
    
            </table>
    
            <nav aria-label="Page navigation example">
        
                <ul class="pagination pagination-sm justify-content-center">
            
                <?php $pagination->pagingButton(); ?>
        
                </ul>
    
            </nav>

        </div>

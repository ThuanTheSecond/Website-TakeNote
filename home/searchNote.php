<?php
    session_start();
    include("..\utils\utils.php");
    include("..\db\dbhelper.php");
    if(isset($_POST['search_key'])){
        $keyword = $_POST['search_key'];
        $search_key1 = str_replace(" ","%' and N_title LIKE '%", trim($keyword));
        $search_key2 = str_replace(" ","%' and N_descritption LIKE '%", trim($keyword));
        $sql = "select N_id, N_title, N_descritption, cate_name, note.cate_id from note 
        join category on category.cate_id = note.cate_id where N_title like '%$search_key1%' or N_descritption like '%$search_key2%'";

        $queryNote = mysqli_query(connect_DB(),$sql);
        $noteList = array();
        $noteList = $queryNote->fetch_all(MYSQLI_ASSOC);
        $html ='';
        if(!$noteList){
            $html .='The Note is not exists';
        }else{
            foreach($noteList as $row){
                $html .= '<div class="row block-note">
                            <div class="col-sm-8 content1">
                                <h2 data-txt_id='.$row['N_id'].' contenteditable="true" spellcheck="false" class="title-note noteText" id="titleN'.$row['N_id'].'">'.$row['N_title'].'</h2>
                                <p data-txt_id='.$row['N_id'].' contenteditable="true" spellcheck="false" class="desc-note noteText" id="descN'.$row['N_id'].'">'.$row['N_descritption'].'</p>
                            </div>
                            <div class="col-sm-4 content2">
                                <p class="cate-note">'.$row['cate_name'].'</p>
                                <div class="btn-note">
                                    <button data-delN_id='.$row['N_id'].' class="btn btn-warning delbtn" id="button_del_note"><i class="fa fa-trash"></i></button>
                                    <button data-uptN_id='.$row['N_id'].' data-cate_id='.$row['cate_id'].' class="btn btn-warning uptbtn" id="uptbtn'.$row['N_id'].'" style="display:none;">Save Change</button>
                                </div>
                            </div></div>';
            }
        }
        $json['html']=$html;
        echo json_encode($json);
    }
?>
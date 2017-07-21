<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom35"> Danh sách contact đang giao hàng (<?php echo $total_contact; ?>)</h3>
    </div>
</div>
<form action="<?php echo base_url(); ?>common/action_edit_multi_cod_contact" method="POST" id="action_contact" class="form-inline"> 
    <?php $this->load->view('common/content/filter'); ?>
    <input type="submit" class="btn btn-success btn-export-excel" value="Xuất file excel để in" />
    <input type="submit" class="btn btn-success btn-export-excel-for-viettel" value="Xuất file excel để gửi cho Viettel" />
    <input type="submit" class="btn btn-success export_to_string" value="Xuất thành chuỗi đối soát" /> <br/>
    <?php $this->load->view('common/content/tbl_contact'); ?> 
    <?php $this->load->view('cod/modal/edit_multi_contact'); ?> <br/>
    <input type="submit" class="btn btn-success btn-export-excel" value="Xuất file excel để in" />
    <input type="submit" class="btn btn-success btn-export-excel-for-viettel" value="Xuất file excel để gửi cho Viettel" />
    <input type="submit" class="btn btn-success export_to_string" value="Xuất thành chuỗi" />
    <a href="form.html" class="select_provider"> Chăm sóc các contact đã chọn </a>
</form>
<div class="edit_contact">
    <div class="modal fade export_to_string_modal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog btn-very-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Chuỗi đối soát</h4>
                </div>
                <div class="modal-body">
                    <textarea class="replace_content_2 form-control" style="height: 300px; cursor: auto;" disabled="disabled">
                        
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

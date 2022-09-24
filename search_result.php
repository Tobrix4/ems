<div class="content py-3">
    <h3>Výsledky vyhledávání</h3>
    <hr>
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-body rounded-0">
            <?php 
            $search_text = "Searching Baptismal Record with ";
            if(!empty($_GET['code'])){
                $search_text .= " Code like <b>'{$_GET['code']}'</b>";
            }
            if(!empty($_GET['name']) && !empty($_GET['code'])){
                $search_text .= " or Name like <b>'{$_GET['name']}'</b>";
            }
            if(!empty($_GET['name']) && empty($_GET['code'])){
                $search_text .= " or Name like <b>'{$_GET['name']}'</b>";
            }
            ?>
            <h4><?= $search_text ?></h4>
            <table class="table table-bordered table-striped">
                <colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Baptismal Code</th>
						<th>Full Name</th>
						<th>Date Baptised</th>
						<th>Action</th>
					</tr>
				</thead>
                <tbody>
					<?php 
						$i = 1;
                        $search = "";
                        if(!empty($_GET['code'])){
                            if(empty($search)) $search = " where ";
                            $search .= " `code` LIKE '%{$_GET['code']}%' ";
                        }
                        if(!empty($_GET['name'])){
                            if(empty($search)) 
                                $search = " where ";
                            else
                                $search .= " or ";
                            $search .= " `fullname` LIKE '%{$_GET['name']}%' ";
                        }
                        $sql = "SELECT * from `baptismal_list` {$search} order by unix_timestamp(`fullname`) asc ";
						$qry = $conn->query($sql);
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ($row['code']) ?></td>
							<td><?php echo ucwords($row['fullname']) ?></td>
							<td class=""><?php echo date("M d, Y",strtotime($row['date'])) ?></td>
							<td align="center">
								<a href="./?page=view_record&id=<?= $row['id'] ?>" class="text-muted" target="_blank"><i class="fa fa-external-link-alt text-secondary opacity-75"></i> View Record</a>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    })
</script>
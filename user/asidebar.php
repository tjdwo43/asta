<!-- sidebar-->
<aside class="aside-container bar-close" style="left:-240px;">
	<!-- START Sidebar (left)-->
	<div class="aside-inner">
		<nav class="sidebar" data-sidebar-anyclick-close="">
            <!-- START sidebar nav-->
            <div class="sidebar-title">
                <h3 class="pl-3 font-weight-light">목록</h3> 
                <button type="button" class="btn btn-info pt-0 pb-0" onclick="userListperOrg()">조회</button>
            </div>
			<ul class="sidebar-nav">
                <div class="table-responsive">
                    <table id="assideTable" class="table">
                        <colgroup>
                            <col width="50px"/>
                            <col width="60px"/>
                            <col width="*"/>
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <div class="checkbox c-checkbox d-inline-block">
                                        <label>
                                            <input type="checkbox" name="checkAll">
                                            <span class="fa fa-check"></span>
                                        </label>
                                    </div>
                                </th>
                                <th class="font-weight-normal listSortBtn" onclick="sortTable(1, 'assideTable')"><span class="mr-2">NO</span> <i class="fas fa-sort-up"></i></th>
                                <th class="font-weight-normal listSortBtn" onclick="sortTable(2, 'assideTable')">건물명 <i class="fas fa-sort-up"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach($getBuildingList['data'] as $k => $datum){?>
                                <tr>
                                    <td class="text-center">
                                        <div class="checkbox c-checkbox d-inline-block mt-2">
                                            <label>
                                                <input type="checkbox" name="checkOne" value="<?=$datum['org_code']."_".$datum['org_name']?>">
                                                <span class="fa fa-check"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-left"><?=sprintf("%03d",($k+1));?></td>
                                    <td class="text-left"><?=$datum['org_name']?></td>
                                </tr>
                            <?}?>
                        </tbody>
                    </table>
                </div><!-- END table-responsive-->
            </ul>
            <div class="sidebar-tglBtn">
                <span></span>
                <span></span>
                <span></span>
            </div>
			<!-- END sidebar nav-->
		</nav>
	</div>
	<!-- END Sidebar (left)-->
</aside>
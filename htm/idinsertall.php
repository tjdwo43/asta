            <div class="row">
                <div class="col-xs-12">
                    <h3 class="page-header"><img src="/images/bar.png" > ID 일괄입력</h3>
                </div>
                <form role="form" name="useradd_excel"   action="/htm/excel_up.php" method='post' enctype='multipart/form-data'>
                    <p>아이디 excel로 일괄입력</p>
                    <div class="form-group"><label ><font color='red'> ☎업로드방법 </font></label><br/>
                        <div class="col-lg-12" >
                            1단계: 엑셀화일항목:아이디/이름/아이디/부서/전화번호/이메일(=>제목줄은 삭제함)<br/>
                            2단계: 엑셀화일을 다른이름으로 저장 -> 확장자를 CSV(쉼표로분리)(*.CSV)로 저장<br/>
                            3단계: 해당파일을 찾아보기에서 선택후 UpLoad 버튼 클릭 <br/>
                            4단계: 완료메시지가 나올때까지 기다리세요...<br/>
                            <br/>
                            <div style="width:190px; float:left;"><input type="file" name="id_excel"   maxlength="8" size="8" ></div>
                            <div style="float:left;"><button class="btn btn-info" type="button" onClick="ExcelUpload()">UpLoad</button> </div>                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10"></div>
                    </div>
                </form>
            </div>

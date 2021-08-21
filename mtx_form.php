<?php
	header("Content-Type: Text/html; charset=utf-8");
	session_start();
	
	if(isset($_SESSION["user_name"]) && isset($_SESSION["user_level"])) {
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="UTF-8" />
		<meta name="Robots" content="noindex, nofollow">
		<title>META TO XML &ndash; 정보 입력</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css" />
		<script type="text/javascript" src="./js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="./js/javascript.js"></script>
	</head>
	<body>
		<div id="wrap">
			<header>
				<h1 title="도구 이름">META TO XML &ndash; 정보 입력</h1>
				<p title="도구 설명">논문의 정보를 입력 받아 JATS 규격 논문으로 변환시켜주는 도구입니다. <span id="spn_version" title="도구 버전"></span></p>
			</header>
			<div id="container">
				<form method="post" action="./mtx_engine.php" onsubmit="return frmCheck()">
					<!-- FRONT -->
					<div id="container_front">
						<div id="section_intro" class="div_section">
							<h2>시작하기</h2>
							<p class="p_description" title="프로그램 사용에 필요한 설명입니다.">(필수) : 반드시 입력해야 하는 정보입니다. 입력하지 않으면 진행되지 않습니다.<br />(선택) : 선택적으로 입력할 수 있습니다. 정보가 없다면 빈 칸으로 남겨두세요.</p>
							<p class="p_description">테두리가 붉은색이거나 왼쪽 라벨에 <label class="lbl_essential"></label> 기호가 있는 칸은 값을 필수로 입력해야 합니다.</p>
							<p class="p_description">입력한 값이 올바르지 않을 때, 입력란이 붉은색 테두리로 변합니다. 입력한 값을 확인하세요.</p>
						</div>
						<div id="section_file_config" class="div_section">
							<h2>파일 설정</h2>
							<ul class="align_center lst_inline">
								<li>
									<label for="cfg_jats">JATS 버전</label>
									<select id="cfg_jats" name="cfg_jats">
										<option value="1.0">1.0</option>
										<option value="1.1">1.1</option>
									</select>
								</li>
								<li>
									<label for="cfg_xslt">XSL 버전</label>
									<select id="cfg_xslt" name="cfg_xslt">
										<option value="3.3">3.3</option>
										<option value="4.5">4.5</option>
										<option value="5.0" selected="selected">5.0</option>
									</select>
								</li>
								<li>
									<label for="cfg_lang">대표 언어</label>
									<select id="cfg_lang" name="cfg_lang">
										<option value="en">영어</option>
										<option value="ko">한국어</option>
										<option value="cn">중국어</option>
										<option value="jn">일본어</option>
									</select>
								</li>
								<li>
									<label>새로고침/뒤로가기 제한</label>
									<input type="checkbox" id="chk_key_option" class="chk_default" /><label for="chk_key_option"></label>
								</li>
							</ul>
						</div>
						<div id="section_journal_information" class="div_section">
							<h2>저널 정보</h2>
							<table class="tbl_grid">
								<colgroup>
									<col style="width:10%" />
									<col style="width:15%" />
									<col style="width:10%" />
									<col style="width:15%" />
									<col style="width:10%" />
									<col style="width:15%" />
									<col style="width:10%" />
									<col style="width:5%" />
									<col style="width:10%" />
								</colgroup>
								<tr>
									<td><label for="ai_preset">학회 선택</label></td>
									<td><select id="ai_preset" name="slt_publisher">
										<option value="en">한국양봉학회</option>
									</select></td>
									<td colspan="7"></td>
								</tr>
								<tr>
									<td><label class="lbl_essential" for="jt_en">저널명</label></td>
									<td colspan="8"><input type="text" id="jt_en" name="jt_en" class="inp_default" placeholder="(필수) 영문의 저널명을 입력하세요." title="영문의 저널명을 입력하세요" required /></td>
								</tr>
								<tr>
									<td><label for="jt">대등 저널명</label></td>
									<td colspan="7"><input type="text" id="jt" name="jt" class="inp_default" placeholder="(선택) 다른 언어의 저널명을 입력하세요." title="다른 언어의 저널명을 입력하세요." /></td>
									<td><select name="jt_lang">
										<option value="ko">한국어</option>
										<option value="cn">중국어</option>
										<option value="jn">일본어</option>
									</select></td>
								</tr>
								<tr>
									<td><label class="lbl_essential" for="issn_p">pISSN</label></td>
									<td><input type="text" id="issn_p" name="issn_p" class="inp_default" maxlength="9" placeholder="(필수)" title="출판 ISSN 번호를 입력하세요." pattern="[0-9a-zA-Z]{4}[\-][0-9a-zA-Z]{4}" required /></td>
									<td><label for="issn_e">eISSN</label></td>
									<td><input type="text" id="issn_e" name="issn_e" class="inp_default" maxlength="9" placeholder="(선택)" title="온라인 ISSN 번호를 입력하세요." pattern="[0-9a-zA-Z]{4}[\-][0-9a-zA-Z]{4}" /></td>
									<td><label for="ajt">국내 약칭</label></td>
									<td><input type="text" id="ajt" name="ajt" class="inp_default" placeholder="(선택)" title="국내에 등록된 학회 약칭을 입력하세요." /></td>
									<td><label for="ajt_pub">PMC<br/>등재 저널명</label></td>
									<td colspan="2"><input type="text" id="ajt_pub" name="ajt_pub" class="inp_default" placeholder="(선택)" title="PMC에 등록된 학회 약칭을 입력하세요." /></td>
								</tr>
								<tr>
									<td><label class="lbl_essential" for="ji_pi">발행기관 ID</label></td>
									<td><input type="text" id="ji_pi" name="ji_pi" class="inp_default" maxlength="10" placeholder="(필수)" title="발행기관 ID를 입력하세요." pattern="[A-Z]+" required /></td>
									<td><label for="ji_nlm">NCBI</label></td>
									<td><input type="text" id="ji_nlm" name="ji_nlm" class="inp_default" placeholder="(선택)" title="NCBI에 등록된 ID를 입력하세요." /></td>
									<td><label for="ji_iso">ISO</label></td>
									<td><input type="text" id="ji_iso" name="ji_iso" class="inp_default" placeholder="(선택)" title="ISO에 등록된 ID를 입력하세요." /></td>
									<td><label for="ji_pub">PMC</label></td>
									<td colspan="2"><input type="text" id="ji_pmc" class="inp_default" name="ji_pmc" placeholder="(선택)" title="PMC에 등록된 ID를 입력하세요." /></td>
								</tr>
								<tr>
									<td><label class="lbl_essential" for="pn_en">기관명</label></td>
									<td colspan="8"><input type="text" id="pn_en" name="pn_en" class="inp_default" placeholder="(필수) 영문의 기관명을 입력하세요." title="영문의 기관명을 입력하세요." required /></td>
								</tr>
								<tr>
									<td><label for="pn">대등 기관명</label></td>
									<td colspan="7"><input type="text" id="pn" name="pn" class="inp_default" placeholder="(선택) 다른 언어의 기관명을 입력하세요." title="다른 언어의 기관명을 입력하세요." /></td>
									<td><select name="pn_lang">
										<option value="ko">한국어</option>
										<option value="cn">중국어</option>
										<option value="jn">일본어</option>
									</select></td>
								</tr>
							</table>
						</div>
						<div id="section_article_information" class="div_section">
							<h2>논문 정보</h2>
							<table class="tbl_grid">
								<colgroup>
									<col style="width:10%" />
									<col style="width:15%" />
									<col style="width:10%" />
									<col style="width:15%" />
									<col style="width:10%" />
									<col style="width:15%" />
									<col style="width:10%" />
									<col style="width:5%" />
									<col style="width:10%" />
								</colgroup>
								<tr>
									<td><label class="lbl_essential" for="ai_subject">논문 유형</label></td>
									<td colspan="3"><input type="text" id="ai_subject" name="ai_subject" class="inp_default" placeholder="(필수) 논문 유형을 입력하세요." title="논문 유형을 입력하세요." required /></td>
									<td><label for="ai_doi">논문 DOI</label></td>
									<td colspan="4"><input type="text" id="ai_doi" name="ai_doi" class="inp_default" placeholder="(선택) DOI 주소를 입력하세요." title="DOI 주소를 입력하세요." /></td>
								</tr>
								<tr>
									<td><label class="lbl_essential" for="ai_volume">권</label></td>
									<td><input type="text" id="ai_volume" name="ai_volume" class="inp_default" placeholder="(필수)" title="권을 입력하세요." pattern="[0-9]{1,}" required /></td>
									<td><label for="ai_issue">호</label></td>
									<td><input type="text" id="ai_issue" name="ai_issue" class="inp_default" placeholder="(선택)" title="호를 입력하세요." pattern="[0-9]{1,}" /></td>
									<td><label class="lbl_essential" for="ai_fpage">시작 페이지</label></td>
									<td><input type="text" id="ai_fpage" name="ai_fpage" class="inp_default" placeholder="(필수)" title="시작 페이지를 입력하세요." pattern="[0-9]{1,}" required /></td>
									<td><label class="lbl_essential" for="ai_lpage">끝 페이지</label></td>
									<td colspan="2"><input type="text" id="ai_lpage" name="ai_lpage" class="inp_default" placeholder="(필수)" title="끝 페이지를 입력하세요." pattern="[0-9]{1,}" required /></td>
								</tr>
								<tr>
									<td><label class="lbl_essential" for="at_m">논문 제목</label></td>
									<td colspan="8"><input type="text" id="at_m" name="at_m" class="inp_default" size="100" placeholder="(필수) 대표 언어의 논문 제목을 입력하세요." title="대표 언어의 논문 제목을 입력하세요." required /></td>
								</tr>
								<tr>
									<td><label for="at_t">대등 논문 제목</label></td>
									<td colspan="7"><input type="text" id="at_t" name="at_t" class="inp_default" size="100" placeholder="(선택) 다른 언어의 논문 제목을 입력하세요." title="다른 언어의 논문 제목을 입력하세요." /></td>
									<td><select name="at_t_lang">
										<option value="ko">한국어</option>
										<option value="en">영어</option>
										<option value="cn">중국어</option>
										<option value="jn">일본어</option>
									</select></td>
								</tr>
							</table>
							<div id="section_date" class="div_section_sub">
								<h3>날짜</h3>
								<p class="p_description">값이 있는 순서대로 입력하세요. 2개의 날짜 정보만 있다면 나머지 3개는 공백으로 남기면 됩니다.</p>
								<p class="p_description">논문투고일(Received) / 수정일(Revised) / 심사완료일(Reviewed) / 게재확정일(Accepted) / 최종완료일(Final Received)</p>
								<ul class="align_center">
									<li>
										<label class="lbl_essential">발행일</label>
										<input type="text" name="date_p_y" class="inp_default inp_year" required /><input type="text" name="date_p_m" class="inp_default inp_month" pattern="[0-9]{2}" required /><input type="text" name="date_p_d" class="inp_default inp_day" pattern="[0-9]{2}" />
										<label>발행일 (온라인)</label>
										<input type="text" name="date_e_y" class="inp_default inp_year" /><input type="text" name="date_e_m" class="inp_default inp_month" pattern="[0-9]{2}" /><input type="text" name="date_e_d" class="inp_default inp_day" pattern="[0-9]{2}" />
									</li>
									<li>
										<select name="ht_date_type[]">
											<option value="received">논문투고일</option>
											<option value="rev-recd">수정일</option>
											<option value="accepted">게재확정일</option>
											<option value="rev-request">심사완료일</option>
											<option value="ppreprint">최종완료일</option>
										</select>
										<input type="text" name="ht_date_y[]" class="inp_default inp_year" required /><input type="text" name="ht_date_m[]" pattern="[0-9]{2}" class="inp_default inp_month" required /><input type="text" name="ht_date_d[]" class="inp_default inp_day" pattern="[0-9]{2}" required />
									</li>
									<li>
										<select name="ht_date_type[]">
											<option value="received">논문투고일</option>
											<option value="rev-recd" selected="selected">수정일</option>
											<option value="accepted">게재확정일</option>
											<option value="rev-request">심사완료일</option>
											<option value="ppreprint">최종완료일</option>
										</select>
										<input type="text" name="ht_date_y[]" class="inp_default inp_year" /><input type="text" name="ht_date_m[]" class="inp_default inp_month" pattern="[0-9]{2}" /><input type="text" name="ht_date_d[]" class="inp_default inp_day" pattern="[0-9]{2}" />
									</li>
									<li>
										<select name="ht_date_type[]">
											<option value="received">논문투고일</option>
											<option value="rev-recd">수정일</option>
											<option value="accepted" selected="selected">게재확정일</option>
											<option value="rev-request">심사완료일</option>
											<option value="ppreprint">최종완료일</option>
										</select>
										<input type="text" name="ht_date_y[]" class="inp_default inp_year" /><input type="text" name="ht_date_m[]" class="inp_default inp_month" pattern="[0-9]{2}" /><input type="text" name="ht_date_d[]" class="inp_default inp_day" pattern="[0-9]{2}" />
									</li>
									<li>
										<select name="ht_date_type[]">
											<option value="received">논문투고일</option>
											<option value="rev-recd">수정일</option>
											<option value="accepted">게재확정일</option>
											<option value="rev-request" selected="selected">심사완료일</option>
											<option value="ppreprint">최종완료일</option>
										</select>
										<input type="text" name="ht_date_y[]" class="inp_default inp_year" /><input type="text" name="ht_date_m[]" class="inp_default inp_month" pattern="[0-9]{2}" /><input type="text" name="ht_date_d[]" class="inp_default inp_day" pattern="[0-9]{2}" />
									</li>
									<li>
										<select name="ht_date_type[]">
											<option value="received">논문투고일</option>
											<option value="rev-recd">수정일</option>
											<option value="accepted">게재확정일</option>
											<option value="rev-request">심사완료일</option>
											<option value="ppreprint" selected="selected">최종완료일</option>
										</select>
										<input type="text" name="ht_date_y[]" class="inp_default inp_year" /><input type="text" name="ht_date_m[]" class="inp_default inp_month" pattern="[0-9]{2}" /><input type="text" name="ht_date_d[]" class="inp_default inp_day" pattern="[0-9]{2}" />
									</li>
								</ul>
							</div>
							<div id="section_author" class="div_section_sub">
								<h3>저자</h3>
								<p class="p_description">사용 언어의 개수를 선택한 다음 저자 +/- 버튼으로 인원을 조절하세요. 교신 저자(최대 1명) 여부는 왼쪽의 체크상자를 이용하세요.</p>
								<p class="p_description">사용 언어의 개수를 변경하면 기존에 입력한 정보는 삭제됩니다. 반드시 값 입력 전 사용 언어 개수를 먼저 선택해주세요.</p>
								<div class="align_center">
									<input type="radio" id="author_lang_num_1" name="author_lang_num" value="1" /><label for="author_lang_num_1">1개 언어</label>
									<input type="radio" id="author_lang_num_2" name="author_lang_num" value="2" /><label for="author_lang_num_2">2개 언어</label>
								</div>
								<div id="group_author"></div>
							</div>
							<div id="section_author_information" class="div_section_sub">
								<h3>저자 정보</h3>
								<p class="p_description">사용 언어의 개수를 선택한 다음 정보 +/- 버튼으로 개수를 조절하세요. 정보가 없다면 입력란을 제거해주세요.</p>
								<p class="p_description">사용 언어의 개수를 변경하면 기존에 입력한 정보는 삭제됩니다. 반드시 값 입력 전 사용 언어 개수를 먼저 선택해주세요.</p>
								<div class="align_center">
									<input type="radio" id="author_info_lang_num_0" name="author_info_lang_num" value="0" /><label for="author_info_lang_num_0">사용 안함</label>
									<input type="radio" id="author_info_lang_num_1" name="author_info_lang_num" value="1" /><label for="author_info_lang_num_1">1개 언어</label>
									<input type="radio" id="author_info_lang_num_2" name="author_info_lang_num" value="2" /><label for="author_info_lang_num_2">2개 언어</label>
								</div>
								<div id="group_author_info"></div>
							</div>
							<div id="section_abstract" class="div_section_sub">
								<h3>초록</h3>
								<p class="p_description">사용 언어의 개수를 선택한 다음 +/- 버튼으로 개수를 조절하세요.</p>
								<div class="align_center">
									<input type="radio" id="abstract_lang_num_0" name="abstract_lang_num" value="0" /><label for="abstract_lang_num_0">사용 안함</label>
									<input type="radio" id="abstract_lang_num_1" name="abstract_lang_num" value="1" /><label for="abstract_lang_num_1">1개 언어</label>
									<input type="radio" id="abstract_lang_num_2" name="abstract_lang_num" value="2" /><label for="abstract_lang_num_2">2개 언어</label>
								</div>
								<div id="group_abstract"></div>
							</div>
							<div id="section_keyword" class="div_section_sub">
								<h3>키워드</h3>
								<p class="p_description">사용 언어의 개수를 선택한 다음 +/- 버튼으로 개수를 조절하세요.</p>
								<div class="align_center">
									<input type="radio" id="keyword_lang_num_0" name="keyword_lang_num" value="0" /><label for="keyword_lang_num_0">사용 안함</label>
									<input type="radio" id="keyword_lang_num_1" name="keyword_lang_num" value="1" /><label for="keyword_lang_num_1">1개 언어</label>
									<input type="radio" id="keyword_lang_num_2" name="keyword_lang_num" value="2" /><label for="keyword_lang_num_2">2개 언어</label>
								</div>
								<div id="group_keyword"></div>
							</div>
							<div id="section_special_author_information" class="div_section_sub">
								<input type="checkbox" id="chk_special_author_info" name="chk_special_author_info" class="chk_default" /><label for="chk_special_author_info"></label>
								<h3>특별 저자 정보</h3>
								<p class="p_description">이곳에서 주, 공동, 교신 저자 정보를 추가할 수 있습니다. 특별 저자 정보의 연결번호는 서로 중복될 수 없습니다.</p>
								<div id="group_special_author_info"></div>
							</div>
							<div id="section_funding_group" class="div_section_sub">
								<input type="checkbox" id="chk_funding_group" name="chk_funding_group" class="chk_default" /><label for="chk_funding_group"></label>
								<h3>펀딩 그룹</h3>
								<p class="p_description">이곳에서 펀딩 그룹 정보를 추가할 수 있습니다. 소속 국가는 영문 2자로 입력하세요.</p>
								<div id="group_funding_group"></div>
							</div>
							<div id="section_copyright" class="div_section_sub">
								<input type="checkbox" id="chk_permissions" class="chk_default" /><label for="chk_permissions"></label>
								<h3>저작권 및 라이선스</h3>
								<p class="p_description">이곳에서 저작권 및 라이선스 정보를 추가할 수 있습니다.</p>
								<div id="group_permissions"></div>
							</div>
						</div>
					</div>
					<!-- //FRONT -->
					<!-- BACK -->
					<div id="container_back">
						<div id="section_ending" class="div_section">
							<h2>최종</h2>
							<div id="section_ref" class="div_section_sub">
								<input type="checkbox" id="chk_ref" name="chk_ref" class="chk_default" /><label for="chk_ref"></label>
								<h3>참고문헌</h3>
								<p class="p_description">이곳에서 참고문헌을 추가할 수 있습니다. 제목이 없다면 빈 칸으로 남겨두세요.</p>
								<p class="p_description">일괄 추가 시 기존에 입력한 참고문헌 정보는 삭제됩니다. 반드시 값 입력 전에 사용하세요.</p>
								<div id="group_ref"></div>
							</div>
							<div id="section_ack" class="div_section_sub">
								<input type="checkbox" id="chk_ack" name="chk_ack" class="chk_default" /><label for="chk_ack"></label>
								<h3>사사문구</h3>
								<p class="p_description">이곳에서 사사문구를 추가할 수 있습니다. 제목이 없다면 빈 칸으로 남겨두세요.</p>
								<div id="group_ack"></div>
							</div>
							<div id="section_fn" class="div_section_sub">
								<input type="checkbox" id="chk_fn" name="chk_fn" class="chk_default" /><label for="chk_fn"></label>
								<h3>각주</h3>
								<p class="p_description">이곳에서 각주를 추가할 수 있습니다. 제목이 없다면 빈 칸으로 남겨두세요.</p>
								<p class="p_description">일괄 추가 시 기존의 정보는 삭제됩니다.</p>
								<div id="group_fn"></div>
							</div>
							<div id="section_glossary" class="div_section_sub">
								<input type="checkbox" id="chk_glossary" name="chk_glossary" class="chk_default" /><label for="chk_glossary"></label>
								<h3>기호 설명</h3>
								<p class="p_description">이곳에서 기호 설명을 추가할 수 있습니다. 제목이 없다면 빈 칸으로 남겨두세요.</p>
								<div id="group_glossary"></div>
							</div>
							<div id="section_bio" class="div_section_sub">
								<input type="checkbox" id="chk_bio" name="chk_bio" class="chk_default" /><label for="chk_bio"></label>
								<h3>저자 약력</h3>
								<p class="p_description">이곳에서 저자 약력을 추가할 수 있습니다. 제목이 없다면 빈 칸으로 남겨두세요.</p>
								<div id="group_bio"></div>
							</div>
						</div>
					</div>
					<div id="section_text_change" class="div_section">
						<h2>텍스트 변환</h2>
						<p class="p_description">(A) 입력란에 바꾸고자 하는 텍스트를 입력하고 (B) 입력란에 변경할 텍스트를 입력한 다음 `변환하기` 버튼을 눌러 진행하세요.</p>
						<div> 
							<input type="text" id="chg_text_source" class="inp_default" size="50" placeholder="(A) 원본의 텍스트를 입력하세요." title="(B) 원본의 텍스트를 입력하세요." />를 <input type="text" id="chg_text_result" class="inp_default" size="50" placeholder="(B) 변경할 텍스트를 입력하세요." title="변경할 텍스트를 입력하세요." />로 <button type="button" id="btn_change_text" class="btn_default">변환하기</button>
						</div>
					</div>
					<!-- //BACK -->
					<!-- 완료 버튼 -->
					<div id="container_button" class="div_section align_center">
						<button type="submit" class="btn_submit">작성완료</button>
					</div>
					<!-- //완료 버튼 -->
				</form>
			</div>
			<div class="style_list">
				<ul class="lst_inline lst_style">
					<li><i>I</i></li>
					<li><b>B</b></li>
					<li><sup>p</sup></li>
					<li><sub>b</sub></li>
					<li><u>U</u></li>
					<li><del>O</del></li>
					<li>링크</li>
				</ul>
			</div>
			<footer>
				<img src="./image/img_logo.gif" />
				<p class="p_copyright">By <a href="mailto:ytj0524@naver.com">ytj0524@naver.com</a><br />Copyright 2016 <a href="http://www.nurimedia.co.kr" target="_blank">(주)누리미디어</a> 담당 : <a href="mailto:blueship9@nate.com">콘텐츠제작사업부</a></p>
			</footer>
		</div>
	</body>
</html>
<?
	} else {
		echo "<script>alert('로그인이 필요한 기능입니다.'); location.href = './index.php';</script>";
	}
?>
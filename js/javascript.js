$(document).ready(function() {
	$("#spn_version").text("v1.0.160331");
	
	/* 저자 초기화 */
	$("#author_lang_num_1").attr("checked", true);
	$("#group_author").addform("author", 0);
	setAuthorTagId("author");
	
	$("#author_info_lang_num_0").attr("checked", true);
	$("#abstract_lang_num_0").attr("checked", true);
	$("#keyword_lang_num_0").attr("checked", true);
	
	/* 날짜 입력란 설정 */
	$(".inp_year").attr("size", "8").attr("maxlength", "4").attr("placeholder", "YYYY").attr("title", "연도(Year)를 입력하세요.").attr("pattern", "[0-9]{4}");
	$(".inp_month").attr("size", "4").attr("maxlength", "2").attr("placeholder", "MM").attr("title", "월(Month) 입력하세요.");
	$(".inp_day").attr("size", "4").attr("maxlength", "2").attr("placeholder", "DD").attr("title", "일(Day)을 입력하세요.");
	$(".inp_month").on("blur", function() {
		if($(this).val() != "") {
			if($(this).val() < 1 || $(this).val() > 12) {
				alert("월(Month) 입력란의 값은 1부터 12까지 가능합니다.");
				$(this).val("");$(this).focus();
			}
		}
	});
	$(".inp_day").on("blur", function() {
		if($(this).val() != "") {
			if($(this).val() < 1 || $(this).val() > 31) {
				alert("일(Day) 입력란의 값은 1부터 31까지 가능합니다.");
				$(this).val("");$(this).focus();
			}
		}
	});
	
	/* 펀딩그룹 소속 국가 대문자로 */
	$(document).on("blur", ".funding_group_country", function() {
		$(this).val($(this).val().toUpperCase());
	});
	
	/* 저자 */
	$(":radio[name='author_lang_num']").click(function(e) { // 저자 언어 개수 클릭
		var result = confirm("기존에 입력된 정보가 소실됩니다. 진행하시겠습니까?");
			
		if(result) {
			$("#group_author").empty();
			$("#group_author").addform("author", 0);
			setAuthorTagId("author");
			
		} else {
			e.preventDefault();
		}
	});
	$(document).on("click", "button[name='btn_add_author']", function() { // 저자 추가 클릭
		$(this).addform("author", 1);
		setAuthorTagId("author");
	});
	$(document).on("click", "button[name='btn_del_author']", function() { // 저자 제거 클릭
		var author_num = $("fieldset[name='author']").length;
		if(author_num <= 1) {
			alert("최소 1명 이상의 저자가 필요합니다.");
		} else {
			$(this).parents("fieldset[name='author']").remove();
			setAuthorTagId("author");
		}
	});
	$(document).on("click", "button[name='btn_add_author_label']", function() { // 저자 라벨 추가 클릭
		$(this).addform("author_label", 0);}
	);
	$(document).on("click", "button[name='btn_del_author_label']", function() { // 저자 라벨 제거 클릭
		$(this).parent("div").remove();}
	);
	
	/* 저자 정보 */
	$(":radio[name='author_info_lang_num']").click(function(e) { // 저자 정보 언어 개수 클릭
		var flag = $("#group_author_info").children().length;
		
		if(flag > 0) {
			var result = confirm("기존에 입력된 정보가 소실됩니다. 진행하시겠습니까?");
			
			if(result == true) {
				if($(this).val() == 0) {
					$("#group_author_info").empty();
				} else {
					$("#group_author_info").empty();
					$("#group_author_info").addform("author_info", 0);
					setAuthorTagId("author_info");
				}
			} else {
				e.preventDefault();
			}
		} else {
			if($(this).val() != 0) {
				$("#group_author_info").addform("author_info", 0);
				setAuthorTagId("author_info");
			}
		}
	});
	$(document).on("click", "button[name='btn_add_author_info']", function() { // 저자 정보 추가 클릭
		$(this).addform("author_info", 1);
		setAuthorTagId("author_info");
	});
	$(document).on("click", "button[name='btn_del_author_info']", function() { // 저자 정보 제거 클릭
		var author_info_num = $("fieldset[name='author_info']").length;
		if(author_info_num <= 1) {
			alert("최소 1명 이상의 저자가 필요합니다.");
		} else {
			$(this).parents("fieldset[name='author_info']").remove();
			setAuthorTagId("author_info");
		}
	});
	
	/* 초록 */
	$(":radio[name='abstract_lang_num']").click(function(e) { // 초록 언어 개수 클릭
		var flag = $("#group_abstract").children().length;
		
		if(flag > 0) {
			var result = confirm("기존에 입력된 정보가 소실됩니다. 진행하시겠습니까?");
			
			if(result) {
				if($(this).val() == 0) {
					$("#group_abstract").empty();
				} else {
					$("#group_abstract").empty();
					$("#group_abstract").addform("abstract_grid", 0);
				}
			} else {
				e.preventDefault();
			}
		} else {
			if($(this).val() != 0) {
				$("#group_abstract").addform("abstract_grid", 0);
			}
		}
	});
	$(document).on("click", "button[name='btn_add_abstract']", function() { // 초록 추가 클릭
		$(this).addform("abstract", 0);
	});
	$(document).on("click", "button[name='btn_del_abstract']", function() { // 초록 제거 클릭
		var abstract_num = $(this).parents("ul").children("li").length;
		
		if(abstract_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.");
		} else {
			$(this).parent("li").remove();
		}
	});
	$(document).on("change", "#slt_abstract_type", function() { // 초록 타입 변경
		var abstract_lang_num = $(":radio[name='abstract_lang_num']:checked").val();
		var type = ['m', 's'];
		
		for(var i=0; i<abstract_lang_num; i++) {
			$("#lst_abstract_" + (type[i])).empty();
			$("#lst_abstract_" + (type[i])).addform("abstract", i + 1);
		}
	});
	
	/* 키워드 */
	$(":radio[name='keyword_lang_num']").click(function (e) { // 키워드 언어 개수 클릭
		var flag = $("#group_keyword").children().length;
		
		if(flag) {
			var result = confirm("기존에 입력된 정보가 소실됩니다. 진행하시겠습니까?");
			
			if(result) {
				if($(this).val() == 0) {
					$("#group_keyword").empty();
				} else {
					$("#group_keyword").empty();
					$("#group_keyword").addform("keyword_grid", 0);
				}
			} else {
				e.preventDefault();
			}
		} else {
			$("#group_keyword").empty();
			$("#group_keyword").addform("keyword_grid", 0);
		}
	});
	$(document).on("click", "button[name='btn_add_keyword']", function() { // 키워드 추가 클릭
		$(this).addform("keyword", 0);
	});
	$(document).on("click", "button[name='btn_del_keyword']", function() { // 키워드 제거 클릭
		var keyword_num = $(this).parents("ul").children("li").length;
		
		if(keyword_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.");
		} else {
			$(this).parent("li").remove();
		}
	});
	
	/* 특별 저자 정보 */
	$(document).on("click", "button[name='btn_add_special_author_info']", function() { // 특별 저자 정보 추가 클릭
		$(this).addform("special_author_info", 1);
	});
	$(document).on("click", "button[name='btn_del_special_author_info']", function() { // 특별 저자 정보 제거 클릭
		var special_author_info_num = $("#lst_special_author_info").children("li").length;
		if(special_author_info_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parent("li").remove();
		}
	});
	
	/* 펀딩 그룹 */
	$(document).on("click", "button[name='btn_add_funding_group']", function() { // 펀딩 그룹 추가 클릭
		$(this).addform("funding_group", 1);
	});
	$(document).on("click", "button[name='btn_del_funding_group']", function() { // 펀딩 그룹 제거 클릭
		var funding_group_num = $("#lst_funding_group").children("li").length;
		if(funding_group_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parent().remove();
		}
	});
	
	/* 참고문헌 */
	$(document).on("click", "button[name='btn_add_ref_bulk']", function() { // 참고문헌 일괄 추가 클릭
		var ref_num = $("#lst_reference").children("li").length;
		var ref_bulk_num = $("#ref_bulk_num").val();
		
		if(ref_bulk_num <= 1) {
			alert("1보다 큰 수를 입력하세요.");
			$("#ref_bulk_num").focus();
		} else {
			if(ref_bulk_num >= 100) {
				var result = confirm("100보다 큰 수를 입력하셨습니다. 맞으면 `확인`, 아니면 `취소`를 눌러주세요.")
				
				if(!result) {
					alert("취소하셨습니다.");
					return 0;
				}
			}
			
			$("#lst_reference").empty();
			for(i=0; i<ref_bulk_num; i++) {
				$(this).addform("ref", "bulk");
			}
			setRefTagId();
		}
	});
	$(document).on("click", "button[name='btn_add_ref']", function() { // 참고문헌 추가 클릭
		$(this).addform("ref", 1);
		setRefTagId();
	});
	$(document).on("click", "button[name='btn_del_ref']", function() { // 참고문헌 제거 클릭
		var ref_num = $("#lst_reference").children("li").length;
		if(ref_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parents("li").remove();
			setRefTagId();
		}
	});
	$(document).on("click", "button[name='btn_add_ref_element_citation']", function() { // 참고문헌 <element-citation> 추가 클릭
		$(this).addform("ref", 2);
	});
	$(document).on("click", "button[name='btn_del_ref_element_citation']", function() { // 참고문헌 <element-citation> 제거 클릭
		var ref_element_citation_num = $(this).parents("fieldset[name='bundle_ref']").children("div[name='ref_element_citation']").length;
		if(ref_element_citation_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.");
		} else {
			$(this).parents("div[name='ref_element_citation']").remove();
		}
	});
	$(document).on("click", "button[name='btn_add_ref_element']", function() { // 참고문현 항목 추가 클릭
		$(this).addform("ref", 3);
	});
	$(document).on("click", "button[name='btn_del_ref_element']", function() { // 참고문현 항목 제거 클릭
		var ref_element_num = $(this).parents("div[name='ref_element_citation']").children("div[name='ref_element']").length;
		if(ref_element_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.");
		} else {
			$(this).parents("div[name='ref_element']").remove();
		}
	});
	$(document).on("change", ".ref_element_type", function() { // 참고문헌 항목 타입 변경
		var ref_element_type = $(this).val();
		if(ref_element_type == "author" || ref_element_type == "translator" || ref_element_type == "trans-source") {
			$(this).addform("ref_special_element", ref_element_type);
		} else {
			$(this).addform("ref_special_element", 0);
		}
	});
	$(document).on("change", ".ref_special_element_person_type", function() { // 참고문헌 저자 항목 타입 변경
		var ref_special_element_tag_type = $(this).val();
		var frame = "";
		
		$(this).next("div[name='ref_special_element_person_input']").empty();
		
		if(ref_special_element_tag_type == "name") {
			frame += 
			"<input type='text' class='inp_default' size='15' placeholder='성' />" + 
			"<input type='text' class='inp_default' size='15' placeholder='이름' required />" + 
			"<input type='text' class='inp_default' size='15' placeholder='접두사' />" + 
			"<input type='text' class='inp_default' size='15' placeholder='접미사' />" + 
			"<select>" + 
				"<option value='western'>western</option>" + 
				"<option value='eastern'>eastern</option>" + 
				"<option value='islensk'>islensk</option>" + 
				"<option value='given-only'>given-only</option>" + 
			"</select>";
		} else if(ref_special_element_tag_type == "name_etal") {
			frame += 
			"<input type='text' class='inp_default' size='30' placeholder='연결어' required />";
		}
		
		$(this).next("div[name='ref_special_element_person_input']").append(frame);
	});
	$(document).on("click", "button[name='btn_add_ref_special_element_person']", function() { // 참고문헌 저자 항목 추가 클릭
		var frame ="";
		
		frame += 
		"<div name='ref_special_element_person' class='margin_top_bot'>" + 
			"<select class='ref_special_element_person_type'>" + 
				"<option value='name'>이름</option>" + 
				"<option value='name_etal'>기타</option>" + 
			"</select>" + 
			"<div name='ref_special_element_person_input' style='display:inline-block'>" + 
				"<input type='text' class='inp_default' size='15' placeholder='성' />" + 
				"<input type='text' class='inp_default' size='15' placeholder='이름' required />" + 
				"<input type='text' class='inp_default' size='15' placeholder='접두사' />" + 
				"<input type='text' class='inp_default' size='15' placeholder='접미사' />" + 
				"<select>" + 
					"<option value='western'>western</option>" + 
					"<option value='eastern'>eastern</option>" + 
					"<option value='islensk'>islensk</option>" + 
					"<option value='given-only'>given-only</option>" + 
				"</select>" + 
			"</div>" + 
			"<button type='button' name='btn_add_ref_special_element_person' class='btn_default'>+</button>" + 
			"<button type='button' name='btn_del_ref_special_element_person' class='btn_default'>-</button>" + 
		"</div>";
		
		$(this).parent("div[name='ref_special_element_person']").after(frame);
	});
	$(document).on("click", "button[name='btn_del_ref_special_element_person']", function() { // 참고문헌 저자 항목 제거 클릭
		var a = $(this).parents("div[name='ref_special_element_tag']").children("div[name='ref_special_element_person']").length;
		
		if(a <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.");
		} else {
			$(this).parents("div[name='ref_special_element_person']").remove();
		}
	});

	/* 사사문구 */
	$(document).on("click", "button[name='btn_add_ack']", function() { // 사사문구 추가 클릭
		$(this).addform("ack", 1);
	});
	$(document).on("click", "button[name='btn_del_ack']", function() { // 사사문구 제거 클릭
		var ack_num = $("#lst_ack").children("li").length;
		if(ack_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parent("li").remove();
		}
	});
	
	/* 각주 */
	$(document).on("click", "button[name='btn_add_fn_bulk']", function() { // 각주 일괄 추가 클릭
		var fn_num = $("#lst_fn").children("li").length;
		var fn_bulk_num = $("#fn_bulk_num").val();
		
		if(fn_bulk_num <= 1) {
			alert("1보다 큰 수를 입력하세요.");
			$("#fn_bulk_num").focus();
		} else {
			if(fn_bulk_num >= 100) {
				var result = confirm("100보다 큰 수를 입력하셨습니다. 맞으면 `확인`, 아니면 `취소`를 눌러주세요.");
				
				if(!result) {
					alert("취소하셨습니다.");
					return 0;
				}
			}
			
			$("#lst_fn").empty();
			for(i=0; i<fn_bulk_num; i++) {
				$(this).addform("fn", "bulk");
			}
			setFnTagId();
		}
	});
	$(document).on("click", "button[name='btn_add_fn']", function() { // 각주 추가 클릭
		$(this).addform("fn", 1);
		setFnTagId();
	});
	$(document).on("click", "button[name='btn_del_fn']", function() { // 각주 제거 클릭
		var fn_num = $("#lst_fn").children("li").length;
		if(fn_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parents("li").remove();
			setFnTagId();
		}
	});
	$(document).on("click", "button[name='btn_add_fn_p']", function() { // 각주 문단 추가 클릭
		$(this).addform("fn", 2);
		setFnTagId();
	});
	$(document).on("click", "button[name='btn_del_fn_p']", function() { // 각주 문단 제거 클릭
		var fn_p_num = $(this).parents("#lst_fn_p").children("li").length;
		
		if(fn_p_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.");
		} else {
			$(this).parent("li").remove();
			setFnTagId();	
		}
	});
	
	/* 기호 설명 */
	$(document).on("click", "button[name='btn_add_glossary']", function() { // 기호 추가 클릭
		$(this).addform("glossary", 1);
	});
	$(document).on("click", "button[name='btn_del_glossary']", function() { // 기호 제거 클릭
		var glossary_num = $("#lst_glossary").children("li").length;
		if(glossary_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parent("li").remove();
		}
	});
	
	/* 저자 약력 */
	$(document).on("click", "button[name='btn_add_bio']", function() { // 저자 약력 추가 클릭
		$(this).addform("bio", 1);
	});
	$(document).on("click", "button[name='btn_del_bio']", function() { // 저자 약력 제거 클릭
		var bio_num = $("#lst_bio").children("li").length;
		if(bio_num <= 1) {
			alert("최소 1개 이상의 항목이 필요합니다.\n정보가 없다면 체크박스의 체크를 해제하세요.");
		} else {
			$(this).parent("li").remove();
		}
	});
	
	/* 태그 유무 확인 체크 박스 */
	$(":checkbox").click(function(e) {
		if($(this).attr("id") != "chk_key_option") {
			var chk_id = $(this).attr("id").split('_');
			var target = "", result = "";
			
			if($(this).prop("checked")) {
				result = 1;
			} else {
				result = confirm("기존에 입력된 정보가 소실됩니다. 진행하시겠습니까?");
			}
			
			if(result) {
				for(var i=1; i<chk_id.length; i++) {
					if(i > 1) target += '_';
					target += chk_id[i];
				}
				
				if($("#" + (chk_id[0] + '_' + target)).prop("checked")) {
					$("#group_" + target).addform(target, 0);
					
					if(target == "fn") {setFnTagId();}
					else if(target == "ref") {setRefTagId();}
				} else {
					$("#group_" + target).empty();
					
					if(target == "fn") {setFnTagId();}
					else if(target == "ref") {setRefTagId();}
				}
			} else {
				e.preventDefault();
			}
		}
	});
	
	/* 앞뒤 공백 제거 */
	$(document).on("blur", ":text", function() {
		$(this).val($.trim($(this).val()));
	});
	
	/* 텍스트 일괄 변환 */
	function replaceAll(str, searchStr, replaceStr) {
		return str.split(searchStr).join(replaceStr);
	}
	$("#btn_change_text").click(function() {
		var text_source = $("#chg_text_source").val();
		var text_result = $("#chg_text_result").val();
		var result = confirm("아래와 같이 변경됩니다. 진행하시겠습니까?\n\n원본 : " + text_source + "\n변경 : " + text_result);
		
		if(result) {
			if(text_source == "" || text_result == "") {
				if(text_source == "") {
					alert("원본의 텍스트를 입력하세요.");
					$("#chg_text_source").focus();
				} else {
					alert("변경할 텍스트를 입력하세요.");
					$("#chg_text_result").focus();
				}
			} else {
				$("input[type='text']").each(function() {
					if($(this).attr("id") == "chg_text_source" || $(this).attr("id") == "chg_text_result") {return 0;}
					var text = replaceAll($(this).val(), text_source, text_result);
					$(this).val(text);
				});
				$("textarea").each(function() {
					var text = replaceAll($(this).val(), text_source, text_result);
					$(this).val(text);
				});
			}
		} else {
			return 0;
		}
	});
	
	/* 드래그 스타일 지정 
	$(document).on("mousedown", ":text", function(e) {
		if(e.which == 3) {
			$(window.document).on("contextmenu", function(event){return false;});
			
			var _this = $(this);
			var offset = _this.offset();
			
			offset_y = offset.top;
			offset_x = offset.left;
			
			if(_this.width() < $(".style_list").width()) {
				offset_x = offset.left - (_this.width() / 2);
			}
			$(".style_list").css({top: offset_y - 31, left: offset_x}).show();
			$(".style_list li").eq(0).click(function() {
				setTextStyle(_this, "A");
			});
		} else if(e.which == 1) {
			$(".style_list").hide();
		}
	});
	function setTextStyle(target, style) {
		var t = target;
		
			alert("?");
		if('selectionStart' in t) {
			alert("?");
			if (t.selectionStart != t.selectionEnd) {
				var newText = t.value.substring (0, t.selectionStart) + 
					"[start]" + t.value.substring  (t.selectionStart, t.selectionEnd) + "[end]" +
				t.value.substring (t.selectionEnd);
				t.value = newText;
			}
		}
	}*/
	
	/* 새로고침 뒤로가기 키 제한 */
	$(document).keydown(function(e) {
		if($("#chk_key_option").prop("checked")) {
			var key = (e) ? e.keyCode : event.keyCode;
			
			var t = document.activeElement;
			
			if(key == 8 || key == 116) {
				if(key == 8) {
					if(t.tagName != "INPUT" && t.tagName != "TEXTAREA") {
						if(e) {
							e.preventDefault();
						} else {
							event.keyCode = 0;
							event.returnValue = false;
						}
					}
				} else {
					if(e) {
						e.preventDefault();
					} else {
						event.keyCode = 0;
						event.returnValue = false;
					}
				}
			}
		}
	});
	$("#chk_key_option").attr("checked", "checked");
});
function setAuthorTagId(type) { // 저자, 저자 정보 추가 제거 후 ID 재정렬
	var author_num = $("fieldset[name='" + type + "']").length;
	if(type == "author") {
		for(var i=0; i<author_num; i++) {
			$("fieldset[name='author']:eq(" + i + ")").children("legend").text(i + 1 + "번 저자");
			$(":checkbox[name='chk_author_corresp']:eq(" + i + ")").attr("id", "corresp" + i );
			$(":checkbox[name='chk_author_corresp']:eq(" + i + ")").next("label").attr("for", "corresp" + i);
		}
	} else if(type == "author_info") {
		for(var i=0; i<=author_num; i++) {
			$("fieldset[name='author_info']:eq(" + i + ")").children("legend").text(i + 1 + "번 정보");
		}
	} 
}
function setFnTagId() { // 각주 추가 제거 후 ID 재정렬
	var bundle_fn_num = $("fieldset[name='bundle_fn']").length;
	var fn_p_num = 0;
	
	for(var i=0; i<bundle_fn_num; i++) {
		fn_p_num = $("fieldset[name='bundle_fn']:eq(" + i + ")").children("div[name='item_fn_p']").length;
		
		$("fieldset[name='bundle_fn']:eq(" + i + ") > legend").text(i + 1 + "번");
		$(":hidden[name='fn_num[]']:eq(" + i + ")").val(fn_p_num);
		
		for(var j=0; j<fn_p_num; j++) {
			$("fieldset[name='bundle_fn']:eq(" + i + ")").children("div[name='item_fn_p']:eq(" + j + ")").children("textarea").attr("name", "item_fn_p_" + i + "[]");
		}
	}
}
function setRefTagId() { // 참고문헌 추가제거 후 ID 재정렬
	var bundle_ref_num = $("fieldset[name='bundle_ref']").length;
	for(var i=0; i<=bundle_ref_num; i++) {
		$("fieldset[name='bundle_ref']:eq(" + i + ") > legend").text(i + 1 + "번");
		var cnt_ref_element = $(".fld_ref:eq(" + i + ")").children(".div_ref_element").length;
	}
}
function frmCheck() { // 폼 전송 전 작업 목록
	var result = confirm("`확인` 버튼을 누르실 경우 더이상 값을 수정할 수 없습니다.\n\n최종적으로 검수가 끝난 파일이라면 `확인` 버튼을, 아니라면 `취소` 버튼을 눌러 진행하세요.");
	
	if(result) {
		// 교신 저자가 1명이 넘지 않도록
		var author_num = $(":checkbox[name='chk_author_corresp']").length;
		var corresp_author_num = 0, corresp_author_label_num = 0;
		
		for(var i=0; i<author_num; i++) {
			var author_label_num = $("select[name='author_" + i + "_label_type[]']").length;
			
			if($(":checkbox[name='chk_author_corresp']").eq(i).prop("checked")) {
				$(":hidden[name='author_corresp[]']").eq(i).val("1");
				corresp_author_num += 1;
			} else {
				$(":hidden[name='author_corresp[]']").eq(i).val("0");
			}
			
			for(var j=0; j<author_label_num; j++) {
				if($("select[name='author_" + i + "_label_type[]']").eq(j).val() == "corresp") {
					corresp_author_label_num += 1;
				}
			}
			if(corresp_author_num > 1) {
				alert("교신 저자는 최대 1명만 지정 가능합니다.");
				$("html, body").animate({scrollTop: $("#section_author").offset().top}, 1000);
				return false;
			}
			if(corresp_author_label_num > 1) {
				alert("교신 저자 라벨은 최대 1개만 지정 가능합니다.");
				$("html, body").animate({scrollTop: $("#section_author").offset().top}, 1000);
				return false;
			}
		}
		
		// 날짜 공백, 중복 체크
		var date_temp_space = new Array();
		var date_temp_overlap = new Array();
		for(var i=0; i<5; i++) {
			date_temp_space[i] = new Array();
			
			if($(":text[name='ht_date_y[]']").eq(i).val() == "") date_temp_space[i][0] = 0;
			else date_temp_space[i][0] = 1;
			if($(":text[name='ht_date_m[]']").eq(i).val() == "") date_temp_space[i][1] = 0;
			else date_temp_space[i][1] = 1;
			if($(":text[name='ht_date_d[]']").eq(i).val() == "") date_temp_space[i][2] = 0;
			else date_temp_space[i][2] = 1;
			
			date_temp_overlap[i] = $("select[name='ht_date_type[]']").eq(i).val();
		}
		for(var i=0; i<5; i++) {
			if(date_temp_space[i][0] && date_temp_space[i][1] && date_temp_space[i][2]) {
				continue;
			} else if(!date_temp_space[i][0] && !date_temp_space[i][1] && !date_temp_space[i][2]) {
				continue;
			} else {
				alert("날짜 정보 중 값이 일부만 입력된 곳이 있습니다.");
				$("html, body").animate({scrollTop: $("#section_date").offset().top}, 1000);
				return false;
			}
		}
		for(var i=0; i<5; i++) {
			for(var j=i+1; j<5; j++) {
				if(date_temp_overlap[i] == date_temp_overlap[j]) {
					alert("날짜 정보 중 타입이 중복된 값이 있습니다.");
					$("html, body").animate({scrollTop: $("#section_date").offset().top}, 1000);
					return false;
				}
			}
		}
		
		// 특별 저자 정보 연결 번호가 중복되지 않도록
		if($("#chk_special_author_info").prop("checked")) {
			var special_author_info_num = $("#lst_special_author_info").children("li").length;
			var corresp_author_label_num = 0;
			var special_author_no = [];
			
			for(var i=0; i<special_author_info_num; i++) {
				if($("select[name='special_author_type[]']").eq(i).val() == "corresp") {corresp_author_label_num += 1;}
				if(corresp_author_label_num > 1) {
					alert("특별 저자 정보에서 교신 저자 정보는 최대 1개만 입력할 수 있습니다.");
					$("html, body").animate({scrollTop: $("#section_special_author_information").offset().top}, 1000);
					return false;
				}
				
				special_author_no[i] = $(":text[name='special_author_no[]']").eq(i).val();
				if(i == (special_author_info_num - 1)) {
					for(var j=0; j<special_author_info_num; j++) {
						for(var k=j + 1; k<special_author_info_num; k++) {
							if(special_author_no[j] == special_author_no[k]) {
								alert("특별 저자 정보에서 라벨 번호는 서로 중복될 수 없습니다.");
								$("html, body").animate({scrollTop: $("#section_special_author_information").offset().top}, 1000);
								return false;
							}
						}
					}
				}
			}
		}
		
		// 참고문헌 ID 설정
		if($("#chk_ref").prop("checked")) {
			var ref_num = $("fieldset[name='bundle_ref']").length;
			
			for(i=0; i<ref_num; i++) {
				var ref_element_citation = $("fieldset[name='bundle_ref']:eq(" + i + ")").children("div[name='ref_element_citation']");
				var ref_element_citation_num = ref_element_citation.length;
				
				$(":hidden[name='ref_element_citation_num[]']:eq(" + i + ")").val(ref_element_citation_num); // ref, ele 개수
				
				//ref_element_citation.children(":hidden").attr("name", "ref_element_num[]");
				ref_element_citation.children("select").attr("name", "ref_element_citation_type_" + i + "[]"); // ele 타입
				
				for(var j=0; j<$(":hidden[name='ref_element_citation_num[]']:eq(" + i + ")").val(); j++) {
					var ref_element = $("fieldset[name='bundle_ref']:eq(" + i + ")").children("div[name='ref_element_citation']:eq(" + j + ")").children("div[name='ref_element']");
					var ref_element_num = ref_element.length;
					
					for(var k=0, l=0; k<ref_element_num; k++) {
						var target = ref_element.eq(k).children("select").val();
						
						ref_element.eq(k).children("select").attr("name", "ref_element_type_" + i + "_" + j + "[]");
						
						if(target == "author" || target == "translator") {
							var ref_special_element_person = ref_element.eq(k).find("div[name='ref_special_element_person']");
							var ref_special_element_person_num = ref_special_element_person.length;
							
							ref_element.eq(k).find(":hidden").attr("name", "ref_element_content_" + i + "_" + j + "[]");
							ref_special_element_person.children("select").attr("name", "person_group_tag_type_" + i + "_" + j + "_" + l + "[]");
							
							for(var m=0; m<ref_special_element_person_num; m++) {
								if(ref_special_element_person.eq(m).children("select").val() == "name") {
									ref_special_element_person.find(":text[placeholder='성']").attr("name", "person_group_surname_" + i + "_" + j + "_" + l + "[]");
									ref_special_element_person.find(":text[placeholder='이름']").attr("name", "person_group_given_name_" + i + "_" + j + "_" + l + "[]");
									ref_special_element_person.find(":text[placeholder='접두사']").attr("name", "person_group_prefix_" + i + "_" + j + "_" + l + "[]");
									ref_special_element_person.find(":text[placeholder='접미사']").attr("name", "person_group_suffix_" + i + "_" + j + "_" + l + "[]");
									ref_special_element_person.find(":text[placeholder='접미사']").next("select").attr("name", "person_group_name_style_" + i + "_" + j + "_" + l + "[]");
								} else if(ref_special_element_person.eq(m).children("select").val() == "name_etal") {
									ref_special_element_person.find(":text[placeholder='연결어']").attr("name", "person_group_etal_" + i + "_" + j + "_" + l + "[]");
								}
							}
						} else {
							ref_element.eq(k).find(":text").attr("name", "ref_element_content_" + i + "_" + j + "[]");
							
							if(target == "trans-source") {
								ref_element.eq(k).find(":text").next("select").attr("name", "ref_special_element_type_" + i + "_" + j + "_" + k);
							}
						}
						l++;
					}
				}
			}
		}
	} else {
		return false;
	}
}
(function($) {
	$.fn.extend({
		addform: function(target, argument) {
			var frame = "", opt_select = "", this_index = 0;
			var type = ['m', 's'];
			
			if(target == "author" || target == "author_info") { // 저자, 저자 정보
				var lang_num = $(":radio[name='" + target + "_lang_num']:checked").val();
				
				if(target == "author") {
					frame += 
					"<fieldset name='author'>" + 
						"<legend></legend>" + 
						"<div name='author'>" + 
							"<input type='hidden' name='author_corresp[]' />" + 
							"<input type='checkbox' name='chk_author_corresp' class='chk_default' /><label></label>";
					for(var i=0; i<lang_num; i++) {
						if(i == 1) {opt_select = "selected='selected'";}
						frame += "&nbsp;" + 
							"<input type='text' name='author_surname_" + type[i] + "[]' class='inp_default' size='12' placeholder='성' title='저자의 성을 입력하세요.' required />" + 
							"<input type='text' name='author_givenname_" + type[i] + "[]' class='inp_default' size='12' placeholder='이름' title='저자의 이름을 입력하세요.' required />" + 
							"<select name='author_name_style_" + type[i] + "[]'>" + 
								"<option value='western'>western</option>" + 
								"<option value='eastern'>eastern</option>" + 
								"<option value='islensk' " + opt_select + ">islensk</option>" + 
							"</select>" + 
							"<select name='author_name_lang_" + type[i] + "[]'>" + 
								"<option value='en'>영어</option>" + 
								"<option value='ko' " + opt_select + ">한국어</option>" + 
								"<option value='cn'>중국어</option>" + 
								"<option value='jn'>일본어</option>" + 
							"</select>";
					}			
					frame += "&nbsp;" + 
							"<button type='button' name='btn_add_author' class='btn_default'>저자 +</button>" + 
							"<button type='button' name='btn_del_author' class='btn_default'>저자 -</button>" + 
							"<button type='button' name='btn_add_author_label' class='btn_default'>라벨 +</button>" + 
						"</div>" + 
						"<div class='div_author_label'></div>" + 
					"</fieldset>";
				} else if(target == "author_info") {
					frame += 
					"<fieldset name='author_info'>" + 
						"<legend></legend>";
					for(var i=0; i<lang_num; i++) {
						if(i == 1) {opt_select = "selected='selected'";}
						frame += 
						"<div class='margin_top_bot align_center'>" + 
							"<input type='text' name='author_info_label_" + type[i] + "[]' class='inp_default' placeholder='라벨' style='width:100px' />" + 
							"<input type='text' name='author_info_" + type[i] + "[]' class='inp_default' placeholder='저자 정보를 입력하세요.' style='width:580px' required />" + 
							"<select name='author_info_lang_" + type[i] + "[]' style='width:104px'>" + 
								"<option value='en'>영어</option>" + 
								"<option value='ko' " + opt_select + ">한국어</option>" + 
								"<option value='cn'>중국어</option>" + 
								"<option value='jn'>일본어</option>" + 
							"</select><br />" + 
							"<input type='text' name='author_info_country_" + type[i] + "[]' class='inp_default' placeholder='국가' style='width:240px' />" + 
							"<input type='text' name='author_info_phone_" + type[i] + "[]' class='inp_default' maxlength='15' placeholder='전화번호' pattern='[0-9|\\-|\\+]{1,}' style='width:150px' />" + 
							"<input type='text' name='author_info_fax_" + type[i] + "[]' class='inp_default' maxlength='15' placeholder='팩스번호' pattern='[0-9|\\-|\\+]{1,}' style='width:150px' />" + 
							"<input type='email' name='author_info_email_" + type[i] + "[]' class='inp_default' placeholder='이메일' style='width:240px' />" + 
						"</div>";
					}
					frame += 
						"<div class='margin_top_bot align_center'>" + 
							"<button type='button' name='btn_add_author_info' class='btn_default'>정보 +</button>" + 
							"<button type='button' name='btn_del_author_info' class='btn_default'>정보 -</button>" + 
						"</div>" + 
					"</fieldset>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parents("fieldset[name='" + target + "']").after(frame);}
			} else if(target == "author_label") { // 저자 라벨
				this_index = this.parent("div").index("div[name='author']");
				frame += 
				"<div class='item_author_label'>" + 
					"<select name='author_" + this_index + "_label_type[]'>" + 
						"<option value='aff'>일반 저자</option>" + 
						"<option value='corresp'>교신 저자</option>" + 
						"<option value='first-author'>주 저자</option>" + 
						"<option value='co-author'>공동 저자</option>" + 
					"</select>" + 
					"<input type='text' name='author_" + this_index + "_label_text[]' class='inp_default' size='8' placeholder='라벨' required />" + 
					"<input type='text' name='author_" + this_index + "_label_no[]' class='inp_default' size='8' placeholder='연결번호' pattern='[0-9]{1,}' required />" + 
					"<button type='button' name='btn_del_author_label' class='btn_delete'>x</button>" + 
				"</div>";
				this.parent("div").next(".div_author_label").append(frame);
			} else if(target == "abstract_grid") { // 초록 틀
				var abstract_lang_num = $(":radio[name='abstract_lang_num']:checked").val();
				
				frame += 
					"<div class='margin_top_bot'>" + 
						"<label>초록 타입</label>" + 
						"<select id='slt_abstract_type' name='slt_abstract_type'>" + 
							"<option value='p'>문단</option>" + 
							"<option value='sec'>제목 + 문단</option>" + 
						"</select>" + 
					"</div>";
				
				for(var i=0; i<abstract_lang_num; i++) {
					if(i == 1) {opt_select = "selected"; frame += "<br />";}
					frame += 
					"<select name='abstract_lang[]'>" + 
						"<option value='en'>영어</option>" + 
						"<option value='ko' " + opt_select + ">한국어</option>" + 
						"<option value='cn'>중국어</option>" + 
						"<option value='jn'>일본어</option>" + 
					"</select>" + 
					"<button type='button' name='btn_add_abstract' class='btn_default'>문단 +</button>" + 
					"<ul id='lst_abstract_" + type[i] + "'>" + 
						"<li>" + 
							"<textarea name='abstract_content_" + type[i] + "[]' cols='120' rows='5' placeholder='문단의 내용을 입력하세요.' title='문단의 내용을 입력하세요.' required></textarea>" + 
							"<button type='button' name='btn_del_abstract' class='btn_delete'>x</button>" + 
						"</li>" + 
					"</ul>";
				}
				
				this.append(frame);
			} else if(target == "abstract") { // 초록
				var abstract_lang_num = 0;
				var abstract_type = $("#slt_abstract_type").val();
				
				if(argument == 0) {abstract_lang_num = this.index("button[name='btn_add_abstract']");}
				else if(argument == 1) {abstract_lang_num = 0;}
				else if(argument == 2) {abstract_lang_num = 1;}
				
				if(abstract_type == "p") {
					frame += 
					"<li>" + 
						"<textarea name='abstract_content_" + type[abstract_lang_num] + "[]' cols='120' rows='5' placeholder='문단의 내용을 입력하세요.' title='문단의 내용을 입력하세요.' required></textarea>" + 
						"<button type='button' name='btn_del_abstract' class='btn_delete'>x</button>"
					"</li>";
				} else if(abstract_type == "sec") {
					frame += 
					"<li>" + 
						"<input type='text' name='abstract_title_" + type[abstract_lang_num] + "[]' class='inp_default' placeholder='문단의 제목을 입력하세요.' size='120' title='문단의 제목을 입력하세요.' required />" + 
						"<textarea name='abstract_content_" + type[abstract_lang_num] + "[]' cols='120' rows='5' placeholder='문단의 내용을 입력하세요.' title='문단의 내용을 입력하세요.' required></textarea>" + 
						"<button type='button' name='btn_del_abstract' class='btn_delete'>x</button>"
					"</li>";
				}
				$("#lst_abstract_" + (type[abstract_lang_num])).append(frame);
			} else if(target == "keyword_grid") { // 키워드 틀
				var keyword_lang_num = $(":radio[name='keyword_lang_num']:checked").val();
				
				for(var i=0; i<keyword_lang_num; i++) {
					if(i == 1) {opt_select = "selected"; frame += "<br />";}
					frame += 
					"<select name='kwd_lang[]'>" + 
						"<option value='en'>영어</option>" + 
						"<option value='ko' " + opt_select + ">한국어</option>" + 
						"<option value='cn'>중국어</option>" + 
						"<option value='jn'>일본어</option>" + 
					"</select>" + 
					"<button type='button' name='btn_add_keyword' class='btn_default'>키워드 +</button>" + 
					"<ul id='lst_keyword_" + type[i] + "' class='lst_inline'>" + 					
						"<li>" + 
							"<input type='text' name='kwd_" + type[keyword_lang_num] + "[]' class='inp_default' size='40' required />" + 
							"<button type='button' name='btn_del_keyword' class='btn_delete'>x</button>" + 
						"</li>" + 
					"</ul>";
				}
				this.append(frame);
			} else if(target == "keyword") { // 키워드
				var keyword_lang_num = this.index("button[name='btn_add_keyword']");
				
				frame += 
				"<li>" + 
					"<input type='text' name='kwd_" + type[keyword_lang_num] + "[]' class='inp_default' size='40' required />" + 
					"<button type='button' name='btn_del_keyword' class='btn_delete'>x</button>" + 
				"</li>";
				$("#lst_keyword_" + (type[keyword_lang_num])).append(frame);
			} else if(target == "special_author_info") { // 특별 저자 정보
				if(argument == 0) {
					frame += 
					"<ul id='lst_special_author_info'>";
				}
				if(argument <= 1) {
					frame +=
						"<li>" + 
							"<select name='special_author_type[]'>" + 
								"<option value='corresp'>교신 저자</option>" + 
								"<option value='first-author'>주 저자</option>" + 
								"<option value='co-author'>공동 저자</option>" + 
							"</select>" + 
							"<input type='text' name='special_author_label[]' class='inp_default' size='5' placeholder='라벨' />" + 
							"<input type='text' name='special_author_no[]' class='inp_default' size='7' pattern='[0-9]{1,3}' placeholder='연결번호' required />" + 
							"<input type='text' name='special_author_info[]' class='inp_default' size='90' placeholder='저자 정보를 입력하세요.' required />" + 
							"<button type='button' name='btn_add_special_author_info' class='btn_default'>+</button>" + 
							"<button type='button' name='btn_del_special_author_info' class='btn_default'>-</button>" + 
						"</li>";
				}
				if(argument == 0) {
					frame +=
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parent("li").after(frame);}
			} else if(target == "funding_group") { // 펀딩 그룹
				if(argument == 0) {
					frame += 
					"<ul id='lst_funding_group'>";
				}
				if(argument <= 1) {
					frame +=
						"<li>" + 
							"<input type='text' name='funding_group_country[]' class='inp_default' class='funding_group_country' size='10' maxlength='2' pattern='[a-zA-Z]{2}' placeholder='소속 국가' required />" + 
							"<input type='text' name='funding_group_name[]' class='inp_default' size='90' placeholder='기관명을 입력하세요.' required />" + 
							"<input type='text' name='funding_group_no[]' class='inp_default' size='20' placeholder='기관번호' />" + 
							"<button type='button' name='btn_add_funding_group' class='btn_default'>+</button>" + 
							"<button type='button' name='btn_del_funding_group' class='btn_default'>-</button>" + 
						"</li>";
				}
				if(argument == 0) {
					frame +=
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parent("li").after(frame);}
			} else if(target == "permissions") { // 저작권 및 라이선스
				frame += 
				"<div name='item_copyright' class='margin_top_bot'>" + 
					"<label>저작권연도</label>" + 
					"<input type='text' name='copyright_year' class='inp_default' size='6' maxlength='4' pattern='[0-9]{4}' placeholder='YYYY' class='inp_year' /><br />" + 
					"<textarea name='copyright_statement' cols='132' rows='3' placeholder='copyright 정보를 입력하세요.' required /><br />" + 
					"<textarea name='license_p' cols='132' rows='3' placeholder='license 정보를 입력하세요.' />" + 
				"</div>";
				this.append(frame);
			} else if(target == "ack") { // 사사문구
				if(argument == 0) {
					frame += 
					"<input type='text' name='ack_title' class='inp_default' size='120' placeholder='제목을 입력하세요.' />" + 
					"<ul id='lst_ack'>";
				}
				if(argument <= 1) {
					frame += 
						"<li>" + 
							"<textarea name='ack_item[]' cols='118' rows='5' placeholder='내용을 입력하세요.' required ></textarea>" + 
							"<button type='button' name='btn_add_ack' class='btn_default'>+</button>" + 
							"<button type='button' name='btn_del_ack' class='btn_default'>-</button>" + 
						"</li>";
				}
				if(argument == 0) {
					frame +=
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parent("li").after(frame);}
			} else if(target == "fn") { // 각주
				if(argument == 0) {
					frame += 
					"<input type='text' name='fn_title' class='inp_default' size='120' placeholder='제목을 입력하세요.' />" + 
					"<div class='margin_top_bot'>" + 
						"<input type='text' id='fn_bulk_num' class='inp_default' size='5' pattern='[0-9]{1,}' placeholder='개수' />" + 
						"<button type='button' name='btn_add_fn_bulk' class='btn_default'>일괄 추가</button>" + 
					"</div>" + 
					"<ul id='lst_fn'>";
				}
				if(argument <= 1 || argument == "bulk") {
					frame += 
						"<li>" + 
							"<fieldset name='bundle_fn'>" + 
								"<legend></legend>" + 
								"<input type='hidden' id='fn_num' name='fn_num[]' />" + 
								"<ul id='lst_fn_p'>";
				}
				if(argument <= 2 || argument == "bulk") {
					frame += 
									"<li>" + 
										"<textarea cols='115' rows='5' placeholder='내용을 입력하세요.' required ></textarea>" + 
										"<button type='button' name='btn_add_fn_p' class='btn_default'>+</button>" + 
										"<button type='button' name='btn_del_fn_p' class='btn_default'>-</button>" + 
									"</li>";
				}
				if(argument <= 1 || argument == "bulk") {
					frame += 
								
							"</fieldset>" + 
							"<div class='align_center'>" +
								"<button type='button' name='btn_add_fn' class='btn_default'>각주 +</button>" + 
								"<button type='button' name='btn_del_fn' class='btn_default'>각주 -</button>" + 
							"</div>" + 
						"</li>";
				}
				if(argument == 0) {
					frame += 
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parents("li").after(frame);}
				else if(argument == 2) {this.parent("li").after(frame);}
				else if(argument == "bulk") {$("#lst_fn").append(frame);}
			} else if(target == "glossary") { // 기호 설명
				if(argument == 0) {
					frame += 
					"<input type='text' name='glossary_title' class='inp_default' size='120' placeholder='제목을 입력하세요.' />" + 
					"<ul id='lst_glossary'>";
				}
				if(argument <= 1) {
					frame +=
						"<li>" + 
							"<input type='text' name='glossary_item[]' class='inp_default' size='120' placeholder='설명을 입력하세요.' required />" + 
							"<button type='button' name='btn_add_glossary' class='btn_default'>+</button>" + 
							"<button type='button' name='btn_del_glossary' class='btn_default'>-</button>" + 
						"</li>";
				}
				if(argument == 0) {
					frame += 
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parent("li").after(frame);}
			} else if(target == "bio") { // 저자 약력
				if(argument == 0) {
					frame += 
					"<input type='text' name='bio_title' class='inp_default' size='120' placeholder='제목을 입력하세요.' />" + 
					"<ul id='lst_bio'>";
				}
				if(argument <= 1) {
					frame +=
						"<li>" + 
							"<input type='text' name='bio_item[]' class='inp_default' size='120' placeholder='약력을 입력하세요.' required />" + 
							"<button type='button' name='btn_add_bio' class='btn_default'>+</button>" + 
							"<button type='button' name='btn_del_bio' class='btn_default'>-</button>" + 
						"</li>";
				}
				if(argument == 0) {
					frame +=
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parent("li").after(frame);}
			} else if(target == "ref") { // 참고문헌
				if(argument <= 0) {
					frame += 
					"<input type='text' name='ref_title' class='inp_default' size='120' placeholder='제목을 입력하세요.' />" + 
					"<div class='margin_top_bot'>" + 
						"<input type='text' id='ref_bulk_num' class='inp_default' size='10' pattern='[0-9]{1,}' placeholder='개수' />" + 
						"<button type='button' name='btn_add_ref_bulk' class='btn_default'>일괄 추가</button>" + 
					"</div>" + 
					"<ul id='lst_reference'>";
				}
				if(argument <= 1 || argument == "bulk") {
					frame += 
						"<li>" + 
							"<fieldset name='bundle_ref'>" + 
								"<legend></legend>" + 
								"<input type='hidden' name='ref_element_citation_num[]' />";
				}
				if(argument <= 2 || argument == "bulk") {
					frame += 
								"<div name='ref_element_citation' class='margin_top_bot ref_element_citation'>" + 
									"<input type='hidden' />" + 
									"<select>" + 
										"<option value='journal'>저널</option>" + 
										"<option value='book'>서적</option>" + 
										"<option value='conf-proc'>컨퍼런스</option>" + 
										"<option value='thesis'>학위논문</option>" + 
										"<option value='report'>보고서</option>" + 
										"<option value='patent'>특허</option>" + 
										"<option value='web'>웹</option>" + 
										"<option value='other'>기타</option>" + 
									"</select>" + 
									"<button type='button' name='btn_add_ref_element_citation' class='btn_default'>묶음 +</button>" + 
									"<button type='button' name='btn_del_ref_element_citation' class='btn_default'>묶음 -</button>";
				}
				if(argument <= 3 || argument == "bulk") {
					frame += 
									"<div name='ref_element' class='margin_top_bot'>" + 
										"<select class='ref_element_type'>" + 
											"<optgroup label='저자&amp;기관'>" + 
												"<option value='collab'>기관</option>" + 
												"<option value='author'>저자</option>" + 
												"<option value='translator'>저자(번역가)</option>" + 
											"</optgroup>" + 
											"<optgroup label='날짜'>" + 
												"<option value='day'>발행일</option>" + 
												"<option value='month'>발행월</option>" + 
												"<option value='year'>발행년</option>" + 
											"</optgroup>" + 
											"<optgroup label='제목'>" + 
												"<option value='source'>저널명</option>" + 
												"<option value='trans-source'>저널명(번역)</option>" + 
												"<option value='article-title'>제목</option>" + 
												"<option value='chapter-title'>챕터 제목</option>" + 
											"</optgroup>" + 
											"<optgroup label='출판&amp;컨퍼런스'>" + 
												"<option value='publisher-name'>출판사 이름</option>" + 
												"<option value='publisher-loc'>출판사 소재</option>" + 
												"<option value='conf-name'>컨퍼런스 이름</option>" + 
												"<option value='conf-loc'>컨퍼런스 소재</option>" + 
											"</optgroup>" + 
											"<optgroup label='페이지'>" + 
												"<option value='volume'>권</option>" + 
												"<option value='issue'>호</option>" + 
												"<option value='fpage'>시작 페이지</option>" + 
												"<option value='lpage'>끝 페이지</option>" + 
												"<option value='page-range'>불연속 페이지</option>" + 
												"<option value='size'>쪽수</option>" + 
												"<option value='edition'>판</option>" + 
											"</optgroup>" + 
											"<optgroup label='학위&amp;특허&amp;보고서'>" + 
												"<option value='etal'>학위명</option>" + 
												"<option value='patent'>특허 번호</option>" + 
												"<option value='gov'>보고서 번호</option>" + 
											"</optgroup>" + 
											"<optgroup label='웹'>" + 
												"<option value='uri'>링크</option>" + 
												"<option value='date-in-citation'>인용일자</option>" + 
											"</optgroup>" + 
											"<optgroup label='기타'>" + 
												"<option value='comment'>주석</option>" + 
												"<option value='pub-id'>DOI 주소</option>" + 
											"</optgroup>" + 
										"</select>" + 
										"<div name='ref_element_input' class='ref_element_input'>" + 
											"<input type='text' class='inp_default' size='88' required />" + 
										"</div>" + 
										"<button type='button' name='btn_add_ref_element' class='btn_default'>항목 +</button>" + 
										"<button type='button' name='btn_del_ref_element' class='btn_default'>항목 -</button>" + 
									"</div>";
				}
				if(argument <= 2 || argument == "bulk") {
					frame +=
								"</div>";
				}
				if(argument <= 1 || argument == "bulk") {
					frame += 
							"</fieldset>" + 							
							"<div class='margin_top_bot align_center'>" + 
								"<button type='button' name='btn_add_ref' class='btn_default'>참고문헌 +</button>" + 
								"<button type='button' name='btn_del_ref' class='btn_default'>참고문헌 -</button>" + 
							"</div>" + 
							"</div>" + 
						"</li>";
				}
				if(argument == 0) {
					frame +=
					"</ul>";
				}
				
				if(argument == 0) {this.append(frame);}
				else if(argument == 1) {this.parents("li").after(frame);}
				else if(argument == 2) {this.parent("div[name='ref_element_citation']").after(frame);}
				else if(argument == 3) {this.parents("div[name='ref_element']").after(frame);}
				else if(argument == "bulk") {$("#lst_reference").append(frame);}
			} else if(target == "ref_special_element") {
				this.next("div[name='ref_element_input']").empty();
				
				if(argument != 0) {
					if(argument == "author" || argument == "translator") {
						frame += 
						"<input type='hidden' value='0' />" + 
						"<div name='ref_special_element_tag' style='padding:10px;border:1px solid #999'>" + 
							"<div name='ref_special_element_person' class='margin_top_bot'>" + 
								"<select class='ref_special_element_person_type'>" + 
									"<option value='name'>이름</option>" + 
									"<option value='name_etal'>기타</option>" + 
								"</select>" + 
								"<div name='ref_special_element_person_input' style='display:inline-block'>" + 
									"<input type='text' class='inp_default' size='15' placeholder='성' />" + 
									"<input type='text' class='inp_default' size='15' placeholder='이름' required />" + 
									"<input type='text' class='inp_default' size='15' placeholder='접두사' />" + 
									"<input type='text' class='inp_default' size='15' placeholder='접미사' />" + 
									"<select>" + 
										"<option value='western'>western</option>" + 
										"<option value='eastern'>eastern</option>" + 
										"<option value='islensk'>islensk</option>" + 
										"<option value='given-only'>given-only</option>" + 
									"</select>" + 
								"</div>" + 
								"<button type='button' name='btn_add_ref_special_element_person' class='btn_default'>+</button>" + 
								"<button type='button' name='btn_del_ref_special_element_person' class='btn_default'>-</button><br />" + 
							"</div>" + 
						"</div>";
					} else if(argument == "trans-source") {
						frame += 
						"<input type='text' class='inp_default' size='80' />" + 
						"<select>" + 
							"<option value='en'>영어</option>" + 
							"<option value='ko'>한국어</option>" + 
							"<option value='cn'>중국어</option>" + 
							"<option value='jn'>일본어</option>" + 
						"</select>";
					}
				} else {
					frame += "<input type='text' class='inp_default' size='88' required />";
				}
				
				this.next("div[name='ref_element_input']").append(frame);
			}
		}
	});
})(jQuery);
<?php
	header("Content-Type: Text/html; charset=utf-8");
	session_start();
	
	if(!preg_match("/".getenv("HTTP_HOST")."/",getenv("HTTP_REFERER"))) {
		echo "<script>alert('비정상적인 접근입니다.');history.go(-1);</script>";
		exit;
	} else {
		$var_type = array('m', 's');
		$var_lang	= $_POST["cfg_lang"]; // 대표 언어
		$var_jats	= $_POST["cfg_jats"]; // JATS 버전
		$var_article_id = $_POST["ji_pi"]."_".$_POST["date_p_y"]."_v".$_POST["ai_volume"]."n".$_POST["ai_issue"]."_".$_POST["ai_fpage"]; // 논문 ID
		
		/* JATS, xslt 버전 설정 */
		if($var_jats == "1.0") $dtd_param = "v1.0 20120330";
		else if($var_jats == "1.1") $dtd_param = "v1.1 20151215";
		
		$dtd_param = "-//NLM//DTD JATS (Z39.96) Journal Publishing DTD ".$dtd_param."//EN";
		
		$imp	= new DOMImplementation();
		$dtd	= $imp->createDocumentType("article", $dtd_param, "JATS-journalpublishing1.dtd");
		$xslt	= "NuriXml-v".$_POST["cfg_xslt"].".xsl";
		
		/* DOM 객체 생성 */
		$dom = $imp->createDocument("", "", $dtd);
		$dom->version = "1.0";
		$dom->encoding = "utf-8";
		//$dom->appendChild($dom->createProcessingInstruction("xml-stylesheet", "type=\"text/xsl\" href=\"./$xslt\""));

		/* 최상단 노드(article) 생성 */
		$node_root	= $dom->createElement("article");
		$node_root->setAttribute("xmlns:mml", "http://www.w3.org/1998/Math/MathML");
		$node_root->setAttribute("xmlns:xlink", "http://www.w3.org/1999/xlink");
		$node_root->setAttribute("article-type", "research-article");
		$node_root->setAttribute("xml:lang", $var_lang);
		
		$node_front	= $node_root->appendChild($dom->createElement("front"));
		$node_back	= $node_root->appendChild($dom->createElement("back"));
		$node_journal_meta = $node_front->appendChild($dom->createElement("journal-meta"));
		$node_article_meta = $node_front->appendChild($dom->createElement("article-meta"));
		
		/* FRONT */
		// <journal-id>
		$node_journal_id = $node_journal_meta->appendChild($dom->createElement("journal-id"));
		$node_journal_id->appendChild($dom->createTextNode($_POST["ji_pi"]));
		$node_journal_id->setAttribute("journal-id-type", "publisher-id");
		if(!empty($_POST["ji_nlm"])) {
			$node_journal_id_nlm = $node_journal_meta->appendChild($dom->createElement("journal-id"));
			$node_journal_id_nlm->appendChild($dom->createTextNode($_POST["ji_nlm"]));
			$node_journal_id_nlm->setAttribute("journal-id-type", "nlm-ta");
		}
		if(!empty($_POST["ji_iso"])) {
			$node_journal_id_iso = $node_journal_meta->appendChild($dom->createElement("journal-id"));
			$node_journal_id_iso->appendChild($dom->createTextNode($_POST["ji_iso"]));
			$node_journal_id_iso->setAttribute("journal-id-type", "iso-abbrev");
		}
		if(!empty($_POST["ji_pmc"])) {
			$node_journal_id_pub = $node_journal_meta->appendChild($dom->createElement("journal-id"));
			$node_journal_id_pub->appendChild($dom->createTextNode($_POST["ji_pmc"]));
			$node_journal_id_pub->setAttribute("journal-id-type", "pmc");
		}
		
		// <journal-title>
		$node_journal_title_group = $node_journal_meta->appendChild($dom->createElement("journal-title-group"));
		$node_journal_title_en = $node_journal_title_group->appendChild($dom->createElement("journal-title"));
		$node_journal_title_en->appendChild($dom->createTextNode($_POST["jt_en"]));
		$node_journal_title_en->setAttribute("xml:lang", "en");
		if(!empty($_POST["jt"])) {
			$node_journal_title = $node_journal_title_group->appendChild($dom->createElement("journal-title"));
			$node_journal_title->appendChild($dom->createTextNode($_POST["jt"]));
			$node_journal_title->setAttribute("xml:lang", $_POST["jt_lang"]);
		}
		if(!empty($_POST["ajt"])) {
			$node_abbrev_journal_title = $node_journal_title_group->appendChild($dom->createElement("abbrev-journal-title"));
			$node_abbrev_journal_title->appendChild($dom->createTextNode($_POST["ajt"]));
			$node_abbrev_journal_title->setAttribute("xml:lang", "en");
		}
		if(!empty($_POST["ajt_pub"])) {
			$node_abbrev_journal_title = $node_journal_title_group->appendChild($dom->createElement("abbrev-journal-title"));
			$node_abbrev_journal_title->appendChild($dom->createTextNode($_POST["ajt_pub"]));
			$node_abbrev_journal_title->setAttribute("abbrev-type", "pubmed");
		}
		
		// <issn>
		$node_issn_p = $node_journal_meta->appendChild($dom->createElement("issn", $_POST["issn_p"]));
		$node_issn_p->setAttribute("pub-type", "ppub");
		if(!empty($_POST["issn_e"])) {
			$node_issn_e = $node_journal_meta->appendChild($dom->createElement("issn", $_POST["issn_e"]));
			$node_issn_e->setAttribute("pub-type", "epub");
		}
		
		// <publisher-name>
		$node_publisher = $node_journal_meta->appendChild($dom->createElement("publisher"));
		$node_publisher_name_en = $node_publisher->appendChild($dom->createElement("publisher-name"));
		$node_publisher_name_en->appendChild($dom->createTextNode($_POST["pn_en"]));
		$node_publisher_name_en->setAttribute("xml:lang", "en");
		if(!empty($_POST["pn"])) {
			$node_publisher_name = $node_publisher->appendChild($dom->createElement("publisher-name"));
			$node_publisher_name->appendChild($dom->createTextNode($_POST["pn"]));
			$node_publisher_name->setAttribute("xml:lang", $_POST["pn_lang"]);
		}
		
		// <article-id>
		$node_article_id_pi = $node_article_meta->appendChild($dom->createElement("article-id"));
		$node_article_id_pi->appendChild($dom->createTextNode($var_article_id));
		$node_article_id_pi->setAttribute("pub-id-type", "publisher-id");
		if(!empty($_POST["ai_doi"])) {
			$node_article_doi = $node_article_meta->appendChild($dom->createElement("article-id"));
			$node_article_doi->appendChild($dom->createTextNode($_POST["ai_doi"]));
			$node_article_doi->setAttribute("pub-id-type", "doi");
		}
		
		// <subject>
		$node_article_categories = $node_article_meta->appendChild($dom->createElement("article-categories"));
		$node_subj_group = $node_article_categories->appendChild($dom->createElement("subj-group"));
		$node_subj_group->setAttribute("subj-group-type", "heading");
		$node_subject = $node_subj_group->appendChild($dom->createElement("subject"));	
		$node_subject->appendChild($dom->createTextNode($_POST["ai_subject"]));
		
		// <article-title>, <trans-title>
		$node_title_group = $node_article_meta->appendChild($dom->createElement("title-group"));
		$node_article_title_m = $node_title_group->appendChild($dom->createElement("article-title"));
		$node_article_title_m->appendChild($dom->createTextNode($_POST["at_m"]));
		$node_article_title_m->setAttribute("xml:lang", $var_lang);
		if(!empty($_POST["at_t"])) {
			$node_trans_title_group = $node_title_group->appendChild($dom->createElement("trans-title-group"));
			$node_trans_title = $node_trans_title_group->appendChild($dom->createElement("trans-title"));
			$node_trans_title->appendChild($dom->createTextNode($_POST["at_t"]));
			$node_trans_title->setAttribute("xml:lang", $_POST["at_t_lang"]);
		}
		
		$node_contrib_group = $node_article_meta->appendChild($dom->createElement("contrib-group"));
		// <name-alternatives>
		$var_author_lang_num = $_POST["author_lang_num"];
		$var_author_num = count($_POST["author_corresp"]);
		for($i=0; $i<$var_author_num; $i++) {
			$node_contrib = $node_contrib_group->appendChild($dom->createElement("contrib"));
			$node_contrib->setAttribute("contrib-type", "author");
			$node_contrib->setAttribute("xlink:type", "simple");		
			if($_POST["author_corresp"][$i] == 1) {$node_contrib->setAttribute("corresp", "yes");}
			
			if($var_author_lang_num == 1) {
				$node_name = $node_contrib->appendChild($dom->createElement("name"));
			} else if($var_author_lang_num == 2) {
				$node_name_alternatives = $node_contrib->appendChild($dom->createElement("name-alternatives"));
				$node_name = $node_name_alternatives->appendChild($dom->createElement("name"));
			}
			
			for($j=0; $j<$var_author_lang_num; $j++) {
				if($j == 1) {
					$node_name = $node_name_alternatives->appendChild($dom->createElement("name"));
				}
				$node_name->setAttribute("name-style", $_POST["author_name_style_".$var_type[$j]][$i]);
				$node_name->setAttribute("xml:lang", $_POST["author_name_lang_".$var_type[$j]][$i]);
				$node_surname = $node_name->appendChild($dom->createElement("surname"));
				$node_surname->appendChild($dom->createTextNode($_POST["author_surname_".$var_type[$j]][$i]));
				$node_givenname = $node_name->appendChild($dom->createElement("given-names"));
				$node_givenname->appendChild($dom->createTextNode($_POST["author_givenname_".$var_type[$j]][$i]));
			}
			
			if(!empty($_POST["author_".$i."_label_text"][0])) {
				$var_aff_num = count($_POST["author_".$i."_label_text"]);
				for($j=0; $j<$var_aff_num; $j++) {
					$var_label_type	= $_POST["author_".$i."_label_type"][$j];
					$var_label_text	= $_POST["author_".$i."_label_text"][$j];
					$var_label_no	= $_POST["author_".$i."_label_no"][$j];
					
					$node_xref = $node_contrib->appendChild($dom->createElement("xref"));
					$node_xref->appendChild($dom->createTextNode($var_label_text));
					if($var_label_type == "aff") {
						$var_label_no = $var_label_no < 10 ? "0".$var_label_no : $var_label_no;
						$node_xref->setAttribute("ref-type", "aff");
						$node_xref->setAttribute("rid", $var_article_id."_A0".$var_label_no);
					} else if($var_label_type == "corresp") {
						$node_xref->setAttribute("ref-type", "corresp");
						$node_xref->setAttribute("rid", "cor".$var_label_no);
					} else if($var_label_type == "first-author" || $var_label_type == "co-author") {
						$node_xref->setAttribute("ref-type", "corresp");
						$node_xref->setAttribute("rid", "cor".$var_label_no);
					}
				}
			}
		}
		
		// <aff-alternatives>
		$var_author_info_lang_num = $_POST["author_info_lang_num"];
		if($var_author_info_lang_num > 0) {
			$var_author_info_num = count($_POST["author_info_m"]);
			for($i=0; $i<$var_author_info_num; $i++) {
				$var_aff_no = $i + 1;
				$var_aff_no = $var_aff_no < 10 ? "0".$var_aff_no : $var_aff_no;
				
				if($var_author_info_lang_num == 1) {
					$node_aff = $node_contrib_group->appendChild($dom->createElement("aff"));
					$node_aff->setAttribute("xml:lang", $_POST["author_info_lang_m"][$i]);
					$node_aff->setAttribute("id", $var_article_id."_A0".$var_aff_no);
				} else if($var_author_info_lang_num == 2) {
					$node_aff_alternatives = $node_contrib_group->appendChild($dom->createElement("aff-alternatives"));
					$node_aff_alternatives->setAttribute("id", $var_article_id."_A0".$var_aff_no);
					$node_aff = $node_aff_alternatives->appendChild($dom->createElement("aff"));
					$node_aff->setAttribute("xml:lang", $_POST["author_info_lang_m"][$i]);
				}
				
				for($j=0; $j<$var_author_info_lang_num; $j++) {
					if($j == 1) {
						$node_aff = $node_aff_alternatives->appendChild($dom->createElement("aff"));
						$node_aff->setAttribute("xml:lang", $_POST["author_info_lang_s"][$i]);
					}
					
					if(!empty($_POST["author_info_label_".$var_type[$j]][$i])) {
						$node_label = $node_aff->appendChild($dom->createElement("label"));
						$node_label->appendChild($dom->createTextNode($_POST["author_info_label_".$var_type[$j]][$i]));
					}
					$node_institution = $node_aff->appendChild($dom->createElement("institution"));
					$node_institution->appendChild($dom->createTextNode($_POST["author_info_".$var_type[$j]][$i]));
					
					if(!empty($_POST["author_info_country_".$var_type[$j]][$i]) || !empty($_POST["author_info_phone_".$var_type[$j]][$i]) || !empty($_POST["author_info_fax_".$var_type[$j]][$i])) {
						$node_addr_line = $node_aff->appendChild($dom->createElement("addr-line"));
						if(!empty($_POST["author_info_country_".$var_type[$j]][$i])) {
							$node_country = $node_addr_line->appendChild($dom->createElement("country"));
							$node_country->appendChild($dom->createTextNode($_POST["author_info_country_".$var_type[$j]][$i]));
						}
						if(!empty($_POST["author_info_phone_".$var_type[$j]][$i])) {
							$node_phone = $node_addr_line->appendChild($dom->createElement("phone"));
							$node_phone->appendChild($dom->createTextNode($_POST["author_info_phone_".$var_type[$j]][$i]));
						}
						if(!empty($_POST["author_info_fax_".$var_type[$j]][$i])) {
							$node_fax = $node_addr_line->appendChild($dom->createElement("fax"));
							$node_fax->appendChild($dom->createTextNode($_POST["author_info_fax_".$var_type[$j]][$i]));
						}
					}
					if(!empty($_POST["author_info_email_".$var_type[$j]][$i])) {
						$node_email = $node_aff->appendChild($dom->createElement("email"));
						$node_email->appendChild($dom->createTextNode($_POST["author_info_email_".$var_type[$j]][$i]));
					}
				}
			}
		}
		
		// <author-notes>
		if(isset($_POST["special_author_info"])) {
			$node_author_notes = $node_article_meta->appendChild($dom->createElement("author-notes"));
			
			$var_special_author_num = count($_POST["special_author_info"]);
			for($i=0; $i<$var_special_author_num; $i++) {
				$var_special_author_info = $_POST["special_author_info"][$i]; 
				if(!empty($_POST["special_author_label"][$i])) {
					$var_special_author_info = "<sup>".$_POST["special_author_label"][$i]."</sup>".$var_special_author_info;
				}
				if($_POST["special_author_type"][$i] == "corresp") {
					$node_corresp = $node_author_notes->appendChild($dom->createElement("corresp"));
					$node_corresp->appendChild($dom->createTextNode($var_special_author_info));
					$node_corresp->setAttribute("id", "cor".$_POST["special_author_no"][$i]);
				} else if($_POST["special_author_type"][$i] == "first-author" || $_POST["special_author_type"][$i] == "co-author") {
					$node_fn = $node_author_notes->appendChild($dom->createElement("fn"));
					$node_fn->setAttribute("fn-type", "con");
					$node_fn->setAttribute("id", "cor".$_POST["special_author_no"][$i]);
					
					$node_p = $node_fn->appendChild($dom->createElement("p"));
					$node_p->appendChild($dom->createTextNode($var_special_author_info));
				}
			}
		}
		
		// <pub-date>
		$node_pub_date = $node_article_meta->appendChild($dom->createElement("pub-date"));
		if(!empty($_POST["date_p_d"])) {$node_day = $node_pub_date->appendChild($dom->createElement("day", $_POST["date_p_d"]));}
		$node_pub_date->appendChild($dom->createElement("month", $_POST["date_p_m"]));
		$node_pub_date->appendChild($dom->createElement("year", $_POST["date_p_y"]));
		$node_pub_date->setAttribute("pub-type", "ppub");
		
		if(!empty($_POST["date_e_y"]) || !empty($_POST["date_e_m"]) || !empty($_POST["date_e_d"])) {
			$node_pub_date = $node_article_meta->appendChild($dom->createElement("pub-date"));
			if(!empty($_POST["date_e_d"])) {$node_day = $node_pub_date->appendChild($dom->createElement("day", $_POST["date_e_d"]));}
			$node_pub_date->appendChild($dom->createElement("month", $_POST["date_e_m"]));
			$node_pub_date->appendChild($dom->createElement("year", $_POST["date_e_y"]));
			$node_pub_date->setAttribute("pub-type", "epub");
		}
		for($i=0; $i<5; $i++) {
			if(($_POST["ht_date_type"][$i] == "ppreprint") && !empty($_POST["ht_date_y"][$i])) {
				$node_pub_date = $node_article_meta->appendChild($dom->createElement("pub-date"));
				$node_day = $node_pub_date->appendChild($dom->createElement("day", $_POST["ht_date_d"][$i]));
				$node_pub_date->appendChild($dom->createElement("month", $_POST["ht_date_m"][$i]));
				$node_pub_date->appendChild($dom->createElement("year", $_POST["ht_date_y"][$i]));
				$node_pub_date->setAttribute("pub-type", "ppreprint");
			}
		}
		
		// <volume>, <issue>, <fpage>, <lpage>
		$node_volume = $node_article_meta->appendChild($dom->createElement("volume", $_POST["ai_volume"]));
		if(!empty($_POST["ai_issue"])) {$node_issue = $node_article_meta->appendChild($dom->createElement("issue", $_POST["ai_issue"]));}
		$node_fpage = $node_article_meta->appendChild($dom->createElement("fpage", $_POST["ai_fpage"]));
		$node_lpage = $node_article_meta->appendChild($dom->createElement("lpage", $_POST["ai_lpage"]));
		
		// <history>
		$node_history = $node_article_meta->appendChild($dom->createElement("history"));
		for($i=0; $i<5; $i++) {
			if($_POST["ht_date_type"][$i] == "ppreprint") continue;
			$node_date = $node_history->appendChild($dom->createElement("date"));
			$node_date->setAttribute("date-type", $_POST["ht_date_type"][$i]);
			
			$node_date->appendChild($dom->createElement("day", $_POST["ht_date_d"][$i]));
			$node_date->appendChild($dom->createElement("month", $_POST["ht_date_m"][$i]));
			$node_date->appendChild($dom->createElement("year", $_POST["ht_date_y"][$i]));
			if(empty($_POST["ht_date_y"][$i + 1])) break;
		}
		
		// <copyright>, <license>
		if(isset($_POST["copyright_statement"])) {
			$node_permissions = $node_article_meta->appendChild($dom->createElement("permissions"));
			
			$node_copyright_statement = $node_permissions->appendChild($dom->createElement("copyright-statement"));
			$node_copyright_statement->appendChild($dom->createTextNode($_POST["copyright_statement"]));
			
			if(!empty($_POST["copyright_year"])) {$node_permissions->appendChild($dom->createElement("copyright-year", $_POST["copyright_year"]));}
			
			if(!empty($_POST["license_p"])) {
				$node_license = $node_permissions->appendChild($dom->createElement("license"));
				$node_license_p = $node_license->appendChild($dom->createElement("license-p"));
				$node_license_p->appendChild($dom->createTextNode($_POST["license_p"]));
			}	
		}
		
		// <abstract>
		if($_POST["abstract_lang_num"]) {
			$node_abstract = $node_article_meta->appendChild($dom->createElement("abstract"));
			$node_abstract->setAttribute("xml:lang", $_POST["abstract_lang"][0]);
			if($_POST["abstract_lang_num"] == 2) {
				$node_trans_abstract = $node_article_meta->appendChild($dom->createElement("trans-abstract"));
				$node_trans_abstract->setAttribute("xml:lang", $_POST["abstract_lang"][1]);
			}
			
			$var_abstract_type = $_POST["slt_abstract_type"];
			for($i=0; $i<$_POST["abstract_lang_num"]; $i++) {
				$var_abstract_num = count($_POST["abstract_content_".$var_type[$i]]);
				for($j=0; $j<$var_abstract_num; $j++) {
					if($var_abstract_type == "p") {
						if($i == 0) {
							$node_p = $node_abstract->appendChild($dom->createElement("p"));
							$node_p->appendChild($dom->createTextNode($_POST["abstract_content_".$var_type[$i]][$j]));
						} else if($i == 1) {
							$node_p = $node_trans_abstract->appendChild($dom->createElement("p"));
							$node_p->appendChild($dom->createTextNode($_POST["abstract_content_".$var_type[$i]][$j]));
						}
					} else if($var_abstract_type == "sec") {
						if($i == 0) {
							$node_sec = $node_abstract->appendChild($dom->createElement("sec"));
							$node_title = $node_sec->appendChild($dom->createElement("title"));
							$node_title->appendChild($dom->createTextNode($_POST["abstract_title_".$var_type[$i]][$j]));
							$node_p = $node_sec->appendChild($dom->createElement("p"));
							$node_p->appendChild($dom->createTextNode($_POST["abstract_content_".$var_type[$i]][$j]));
						} else if($i == 1) {
							$node_sec = $node_trans_abstract->appendChild($dom->createElement("sec"));
							$node_title = $node_sec->appendChild($dom->createElement("title"));
							$node_title->appendChild($dom->createTextNode($_POST["abstract_title_".$var_type[$i]][$j]));
							$node_p = $node_sec->appendChild($dom->createElement("p"));
							$node_p->appendChild($dom->createTextNode($_POST["abstract_content_".$var_type[$i]][$j]));
						}
						
					}
				}
			}
		}
		
		// <kwd-group>
		if($_POST["keyword_lang_num"]) {
			for($i=0; $i<$_POST["keyword_lang_num"]; $i++) {
				$node_kwd_group = $node_article_meta->appendChild($dom->createElement("kwd-group"));
				$node_kwd_group->setAttribute("xml:lang", $_POST["kwd_lang"][$i]);
				
				$var_kwd_num = count($_POST["kwd_".$var_type[$i]]);
				for($j=0; $j<$var_kwd_num; $j++) {
					$node_kwd = $node_kwd_group->appendChild($dom->createElement("kwd"));
					$node_kwd->appendChild($dom->createTextNode($_POST["kwd_".$var_type[$i]][$j]));
				}
			}
		}
		
		// <funding-group>
		if(isset($_POST["funding_group_country"])) {
			$node_funding_group = $node_article_meta->appendChild($dom->createElement("funding-group"));
			
			$var_funding_group_num = count($_POST["funding_group_country"]);		
			for($i=0; $i<$var_funding_group_num; $i++) {
				$node_award_group = $node_funding_group->appendChild($dom->createElement("award-group"));
				
				$node_funding_group = $node_funding_source = $node_award_group->appendChild($dom->createElement("funding-source"));
				$node_funding_group->appendChild($dom->createTextNode($_POST["funding_group_name"][$i]));
				$node_funding_source->setAttribute("country", $_POST["funding_group_country"][$i]);
				
				if(!empty($_POST["funding_group_no"][$i])) {
					$node_award_id = $node_award_group->appendChild($dom->createElement("award-id"));
					$node_award_id->appendChild($dom->createTextNode($_POST["funding_group_no"][$i]));
				}
			}
		}
		
		/* BACK */
		// <glossary>
		if(isset($_POST["chk_glossary"])) {
			$node_glossary = $node_back->appendChild($dom->createElement("glossary"));
			
			if(!empty($_POST["glossary_title"])) {
				$node_glossary_title = $node_glossary->appendChild($dom->createElement("title"));
				$node_glossary_title->appendChild($dom->createTextNode($_POST["glossary_title"]));
			}
			
			$var_glossary_num = count($_POST["glossary_item"]);
			for($i=0; $i<$var_glossary_num; $i++) {
				$node_glossary_item = $node_glossary->appendChild($dom->createElement("p"));
				$node_glossary_item->appendChild($dom->createTextNode($_POST["glossary_item"][$i]));
			}		
		}
		
		// <fn-group>
		if(isset($_POST["chk_fn"])) {
			$node_fn_group = $node_back->appendChild($dom->createElement("fn-group"));
			
			if(!empty($_POST["fn_title"])) {
				$node_fn_title = $node_fn_group->appendChild($dom->createElement("title"));
				$node_fn_title->appendChild($dom->createTextNode($_POST["fn_title"]));
			}
			
			$var_fn_num = count($_POST["fn_num"]);
			for($i=1; $i<=$var_fn_num; $i++) {
				if($i < 10) {
					$var_fn_no = "00".$i;
				} else if(10 <= $i && $i < 100) {
					$var_fn_no = "0".$i;
				} else if(100 <= $i) {
					$var_fn_no = $i;
				}
				$node_fn = $node_fn_group->appendChild($dom->createElement("fn"));
				$node_fn->setAttribute("id", $var_article_id."_X".$var_fn_no);
				for($j=0; $j<$_POST["fn_num"][$i - 1]; $j++) {
					$node_fn_p = $node_fn->appendChild($dom->createElement("p"));
					$node_fn_p->appendChild($dom->createTextNode($_POST["item_fn_p_".($i - 1)][$j]));
				}
			}
		}
		
		// <ack>
		if(isset($_POST["chk_ack"])) {
			$node_ack = $node_back->appendChild($dom->createElement("ack"));
			
			if(!empty($_POST["ack_title"])) {
				$node_ack_title = $node_ack->appendChild($dom->createElement("title"));
				$node_ack_title->appendChild($dom->createTextNode($_POST["ack_title"]));
			}
			
			$var_ack_num = count($_POST["ack_item"]);
			for($i=0; $i<$var_ack_num; $i++) {
				$node_ack_p = $node_ack->appendChild($dom->createElement("p"));
				$node_ack_p->appendChild($dom->createTextNode($_POST["ack_item"][$i]));
			}
		}
		
		// <ref-list>
		if(isset($_POST["chk_ref"])) {
			$node_ref_list = $node_back->appendChild($dom->createElement("ref-list"));
			
			if(!empty($_POST["ref_title"])) {
				$node_ref_title = $node_ref_list->appendChild($dom->createElement("title"));
				$node_ref_title->appendChild($dom->createTextNode($_POST["ref_title"]));
			}
			
			$var_ref_num = count($_POST["ref_element_citation_num"]);
			for($i=0; $i<$var_ref_num; $i++) {
				// 참고문헌에 있는 레퍼런스 개수만큼 도는 반복문
				$node_ref = $node_ref_list->appendChild($dom->createElement("ref"));
				$node_ref->setAttribute("id", $var_article_id."_B".($i + 1));
				$node_ref->appendChild($dom->createElement("label", $i + 1));
				
				for($j=0; $j<$_POST["ref_element_citation_num"][$i]; $j++) {
					// 특정 레퍼런스에 있는 <element-citation> 개수만큼 도는 반복문
					$node_element_citation = $node_ref->appendChild($dom->createElement("element-citation"));
					$node_element_citation->setAttribute("publication-type", $_POST["ref_element_citation_type_".$i][$j]);
					
					$var_ref_element_num = count($_POST["ref_element_type_".$i."_".$j]);
					for($k=0, $l=0; $k<$var_ref_element_num; $k++) {
						// 특정 <element-citation>에 있는 요소의 개수만큼 도는 반복문
						$var_target = $_POST["ref_element_type_".$i."_".$j][$k];
						$var_content = $_POST["ref_element_content_".$i."_".$j][$k];
						if($var_target == "author" || $var_target == "translator") {
							// 특정 요소가 저자이거나 번역가일 경우
							$var_person_group_tag_num = count($_POST["person_group_tag_type_".$i."_".$j."_".$l]);
							$var_person_group_tag_type = $_POST["person_group_tag_type_".$i."_".$j."_".$l];
							$node_person_group = $node_element_citation->appendChild($dom->createElement("person-group"));
							$node_person_group->setAttribute("person-group-type", $var_target);
							
							for($m=0, $nc=0, $ec=0; $m<$var_person_group_tag_num; $m++) {
								// <person-group>에서 <name>과 <etal> 개수만큼 도는 반복문
								if($var_person_group_tag_type[$m] == "name") {
									$node_name = $node_person_group->appendChild($dom->createElement("name"));
									$node_person_group_name_style = $node_name->setAttribute("name-style", $_POST["person_group_name_style_".$i."_".$j."_".$l][$nc]);
									if(!empty($_POST["person_group_surname_".$i."_".$j."_".$l][$nc])) {
										$node_surname = $node_name->appendChild($dom->createElement("surname"));
										$node_surname->appendChild($dom->createTextNode($_POST["person_group_surname_".$i."_".$j."_".$l][$nc]));
									}
									$node_givenname = $node_name->appendChild($dom->createElement("given-names"));
									$node_givenname->appendChild($dom->createTextNode($_POST["person_group_given_name_".$i."_".$j."_".$l][$nc]));
									if(!empty($_POST["person_group_prefix_".$i."_".$j."_".$l][$nc])) {
										$node_prefix = $node_name->appendChild($dom->createElement("prefix"));
										$node_prefix->appendChild($dom->createTextNode($_POST["person_group_prefix_".$i."_".$j."_".$l][$nc]));
									}
									if(!empty($_POST["person_group_suffix_".$i."_".$j."_".$l][$nc])) {
										$node_suffix = $node_name->appendChild($dom->createElement("suffix"));
										$node_suffix->appendChild($dom->createTextNode($_POST["person_group_suffix_".$i."_".$j."_".$l][$nc]));
									}
									$nc++;
								} else if($var_person_group_tag_type[$m] == "name_etal") {
									$node_etal = $node_person_group->appendChild($dom->createElement("etal"));
									$node_etal->appendChild($dom->createTextNode($_POST["person_group_etal_".$i."_".$j."_".$l][$ec]));
									$ec++;
								}
							}
							$l++;
						} else {
							$node_ref_element = $node_element_citation->appendChild($dom->createElement($var_target));
							$node_ref_element->appendChild($dom->createTextNode($var_content));

							if($var_target == "trans-source") {
								$node_ref_element->setAttribute("xml:lang", $_POST["ref_special_element_type_".$i."_".$j."_".$k]);
							} else if($var_target == "size") {
								$node_ref_element->setAttribute("units", "page");
							} else if($var_target == "pub-id") {
								$node_ref_element->setAttribute("pub-id-type", "doi");
							}
						}
					}
				}
			}
		}
		
		// <bio>
		if(isset($_POST["chk_bio"])) {
			$node_bio = $node_back->appendChild($dom->createElement("bio"));
			
			if(!empty($_POST["bio_title"])) {
				$node_bio_title = $node_bio->appendChild($dom->createElement("title"));
				$node_bio_title->appendChild($dom->createTextNode($_POST["bio_title"]));
			}
			
			$var_bio_num = count($_POST["bio_item"]);
			for($i=0; $i<$var_bio_num; $i++) {
				$node_bio_p = $node_bio->appendChild($dom->createElement("p"));
				$node_bio_p->appendChild($dom->createTextNode($_POST["bio_item"][$i]));
			}		
		}
		
		/* 파일 저장 */
		$dom->appendChild($node_root);
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom = $dom->saveXML();
		
		$dom = preg_replace("/(?:^|\G)  /um", "\t", $dom); // 띄어쓰기를 탭으로
		$dom = preg_replace("/&lt;([\/]?)(sup|sub|overline|underline|italic|bold|email)&gt;/i", "<\\1\\2>", $dom);
		$dom = preg_replace("/&lt;(uri xlink:href=\")([^\"]*)(\")&gt;/i", "<\\1\\2\\3>", $dom);
		$dom = preg_replace("/&lt;(\/uri)&gt;/i", "<\\1>", $dom);
		
		$_SESSION["dom"] = $dom;
		$_SESSION["file_name"] = $var_article_id;
	}
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="UTF-8" />
		<meta name="Robots" content="noindex, nofollow">
		<title>META TO XML &ndash; 다운로드</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css" />
		<script type="text/javascript" src="./js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="./js/javascript.js"></script>
	</head>
	<body>
		<div id="wrap">
			<header>
				<h1 title="도구 이름">META TO XML &ndash; 다운로드</h1>
				<p title="도구 설명">논문의 정보를 입력 받아 JATS 규격 논문으로 변환시켜주는 도구입니다. <span id="spn_version" title="도구 버전"></span></p>
			</header>
			<div id="container" class="align_center">
				<a href="./mtx_output.php">다운로드</a>
			</div>
			<footer>
				<img src="./image/img_logo.gif" />
				<p class="p_copyright">By <a href="mailto:ytj0524@naver.com">ytj0524@naver.com</a><br />Copyright 2016 <a href="http://www.nurimedia.co.kr" target="_blank">(주)누리미디어</a> 담당 : <a href="mailto:blueship9@nate.com">콘텐츠제작사업부</a></p>
			</footer>
		</div>
	</body>
</html>
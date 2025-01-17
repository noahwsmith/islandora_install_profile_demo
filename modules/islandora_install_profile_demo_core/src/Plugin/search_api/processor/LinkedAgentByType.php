<?php

namespace Drupal\islandora_install_profile_demo_core\Plugin\search_api\processor;

use Drupal\search_api\Annotation\SearchApiProcessor;
use Drupal\search_api\Datasource\DatasourceInterface;
use Drupal\search_api\Item\ItemInterface;
use Drupal\search_api\Processor\ProcessorPluginBase;
use Drupal\search_api\Processor\ProcessorProperty;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Adds the item's linked agent separately by type.
 *
 * @SearchApiProcessor(
 *   id = "linked_agent_by_type",
 *   label = @Translation("Linked Agent by Type"),
 *   description = @Translation("adds the item's linked agent separately by type"),
 *   stages = {
 *     "add_properties" = 0,
 *   },
 *   locked = true,
 *   hidden = false,
 * )
 */
class LinkedAgentByType extends ProcessorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions(DatasourceInterface $datasource = NULL): array
  {
    $properties = [];
    if (!$datasource) {
      $rel_types = [
        "abr" => "Abridger (abr)"
        ,"act" => "Actor (act)"
        ,"adp" => "Adapter (adp)"
        ,"rcp" => "Addressee (rcp)"
        ,"anl" => "Analyst (anl)"
        ,"anm" => "Animator (anm)"
        ,"ann" => "Annotator (ann)"
        ,"apl" => "Appellant (apl)"
        ,"ape" => "Appellee (ape)"
        ,"app" => "Applicant (app)"
        ,"arc" => "Architect (arc)"
        ,"arr" => "Arranger (arr)"
        ,"acp" => "Art copyist (acp)"
        ,"adi" => "Art director (adi)"
        ,"art" => "Artist (art)"
        ,"ard" => "Artistic director (ard)"
        ,"asg" => "Assignee (asg)"
        ,"asn" => "Associated name (asn)"
        ,"att" => "Attributed name (att)"
        ,"auc" => "Auctioneer (auc)"
        ,"aut" => "Author (aut)"
        ,"aqt" => "Author in quotations or text abstracts (aqt)"
        ,"aft" => "Author of afterword, colophon, etc. (aft)"
        ,"aud" => "Author of dialog (aud)"
        ,"aui" => "Author of introduction, etc. (aui)"
        ,"ato" => "Autographer (ato)"
        ,"ant" => "Bibliographic antecedent (ant)"
        ,"bnd" => "Binder (bnd)"
        ,"bdd" => "Binding designer (bdd)"
        ,"blw" => "Blurb writer (blw)"
        ,"bkd" => "Book designer (bkd)"
        ,"bkp" => "Book producer (bkp)"
        ,"bjd" => "Bookjacket designer (bjd)"
        ,"bpd" => "Bookplate designer (bpd)"
        ,"bsl" => "Bookseller (bsl)"
        ,"brl" => "Braille embosser (brl)"
        ,"brd" => "Broadcaster (brd)"
        ,"cll" => "Calligrapher (cll)"
        ,"ctg" => "Cartographer (ctg)"
        ,"cas" => "Caster (cas)"
        ,"cns" => "Censor (cns)"
        ,"chr" => "Choreographer (chr)"
        ,"clb" => "Collaborator (clb; deprecated, use Contributor)"
        ,"cng" => "Cinematographer (cng)"
        ,"cli" => "Client (cli)"
        ,"cor" => "Collection registrar (cor)"
        ,"col" => "Collector (col)"
        ,"clt" => "Collotyper (clt)"
        ,"clr" => "Colorist (clr)"
        ,"cmm" => "Commentator (cmm)"
        ,"cwt" => "Commentator for written text (cwt)"
        ,"com" => "Compiler (com)"
        ,"cpl" => "Complainant (cpl)"
        ,"cpt" => "Complainant-appellant (cpt)"
        ,"cpe" => "Complainant-appellee (cpe)"
        ,"cmp" => "Composer (cmp)"
        ,"cmt" => "Compositor (cmt)"
        ,"ccp" => "Conceptor (ccp)"
        ,"cnd" => "Conductor (cnd)"
        ,"con" => "Conservator (con)"
        ,"csl" => "Consultant (csl)"
        ,"csp" => "Consultant to a project (csp)"
        ,"cos" => "Contestant (cos)"
        ,"cot" => "Contestant-appellant (cot)"
        ,"coe" => "Contestant-appellee (coe)"
        ,"cts" => "Contestee (cts)"
        ,"ctt" => "Contestee-appellant (ctt)"
        ,"cte" => "Contestee-appellee (cte)"
        ,"ctr" => "Contractor (ctr)"
        ,"ctb" => "Contributor (ctb)"
        ,"cpc" => "Copyright claimant (cpc)"
        ,"cph" => "Copyright holder (cph)"
        ,"crr" => "Corrector (crr)"
        ,"crp" => "Correspondent (crp)"
        ,"cst" => "Costume designer (cst)"
        ,"cou" => "Court governed (cou)"
        ,"crt" => "Court reporter (crt)"
        ,"cov" => "Cover designer (cov)"
        ,"cre" => "Creator (cre)"
        ,"cur" => "Curator (cur)"
        ,"dnc" => "Dancer (dnc)"
        ,"dtc" => "Data contributor (dtc)"
        ,"dtm" => "Data manager (dtm)"
        ,"dte" => "Dedicatee (dte)"
        ,"dto" => "Dedicator (dto)"
        ,"dfd" => "Defendant (dfd)"
        ,"dft" => "Defendant-appellant (dft)"
        ,"dfe" => "Defendant-appellee (dfe)"
        ,"dgg" => "Degree granting institution (dgg)"
        ,"dgs" => "Degree supervisor (dgs)"
        ,"dln" => "Delineator (dln)"
        ,"dpc" => "Depicted (dpc)"
        ,"dpt" => "Depositor (dpt)"
        ,"dsr" => "Designer (dsr)"
        ,"drt" => "Director (drt)"
        ,"dis" => "Dissertant (dis)"
        ,"dbp" => "Distribution place (dbp)"
        ,"dst" => "Distributor (dst)"
        ,"dnr" => "Donor (dnr)"
        ,"drm" => "Draftsman (drm)"
        ,"dub" => "Dubious author (dub)"
        ,"edt" => "Editor (edt)"
        ,"edc" => "Editor of compilation (edc)"
        ,"edm" => "Editor of moving image work (edm)"
        ,"elg" => "Electrician (elg)"
        ,"elt" => "Electrotyper (elt)"
        ,"enj" => "Enacting jurisdiction (enj)"
        ,"eng" => "Engineer (eng)"
        ,"egr" => "Engraver (egr)"
        ,"etr" => "Etcher (etr)"
        ,"evp" => "Event place (evp)"
        ,"exp" => "Expert (exp)"
        ,"fac" => "Facsimilist (fac)"
        ,"fld" => "Field director (fld)"
        ,"fmd" => "Film director (fmd)"
        ,"fds" => "Film distributor (fds)"
        ,"flm" => "Film editor (flm)"
        ,"fmp" => "Film producer (fmp)"
        ,"fmk" => "Filmmaker (fmk)"
        ,"fpy" => "First party (fpy)"
        ,"frg" => "Forger (frg)"
        ,"fmo" => "Former owner (fmo)"
        ,"fnd" => "Funder (fnd)"
        ,"gis" => "Geographic information specialist (gis)"
        ,"grt" => "Graphic technician (grt; deprecated, use Artist)"
        ,"hnr" => "Honoree (hnr)"
        ,"hst" => "Host (hst)"
        ,"his" => "Host institution (his)"
        ,"ilu" => "Illuminator (ilu)"
        ,"ill" => "Illustrator (ill)"
        ,"ins" => "Inscriber (ins)"
        ,"itr" => "Instrumentalist (itr)"
        ,"ive" => "Interviewee (ive)"
        ,"ivr" => "Interviewer (ivr)"
        ,"inv" => "Inventor (inv)"
        ,"isb" => "Issuing body (isb)"
        ,"jud" => "Judge (jud)"
        ,"jug" => "Jurisdiction governed (jug)"
        ,"lbr" => "Laboratory (lbr)"
        ,"ldr" => "Laboratory director (ldr)"
        ,"lsa" => "Landscape architect (lsa)"
        ,"led" => "Lead (led)"
        ,"len" => "Lender (len)"
        ,"lil" => "Libelant (lil)"
        ,"lit" => "Libelant-appellant (lit)"
        ,"lie" => "Libelant-appellee (lie)"
        ,"lel" => "Libelee (lel)"
        ,"let" => "Libelee-appellant (let)"
        ,"lee" => "Libelee-appellee (lee)"
        ,"lbt" => "Librettist (lbt)"
        ,"lse" => "Licensee (lse)"
        ,"lso" => "Licensor (lso)"
        ,"lgd" => "Lighting designer (lgd)"
        ,"ltg" => "Lithographer (ltg)"
        ,"lyr" => "Lyricist (lyr)"
        ,"mfp" => "Manufacture place (mfp)"
        ,"mfr" => "Manufacturer (mfr)"
        ,"mrb" => "Marbler (mrb)"
        ,"mrk" => "Markup editor (mrk)"
        ,"med" => "Medium (med)"
        ,"mdc" => "Metadata contact (mdc)"
        ,"mte" => "Metal-engraver (mte)"
        ,"mtk" => "Minute taker (mtk)"
        ,"mod" => "Moderator (mod)"
        ,"mon" => "Monitor (mon)"
        ,"mcp" => "Music copyist (mcp)"
        ,"msd" => "Musical director (msd)"
        ,"mus" => "Musician (mus)"
        ,"nrt" => "Narrator (nrt)"
        ,"osp" => "Onscreen presenter (osp)"
        ,"opn" => "Opponent (opn)"
        ,"orm" => "Organizer (orm)"
        ,"org" => "Originator (org)"
        ,"oth" => "Other (oth)"
        ,"own" => "Owner (own)"
        ,"pan" => "Panelist (pan)"
        ,"ppm" => "Papermaker (ppm)"
        ,"pta" => "Patent applicant (pta)"
        ,"pth" => "Patent holder (pth)"
        ,"pat" => "Patron (pat)"
        ,"prf" => "Performer (prf)"
        ,"pma" => "Permitting agency (pma)"
        ,"pht" => "Photographer (pht)"
        ,"ptf" => "Plaintiff (ptf)"
        ,"ptt" => "Plaintiff-appellant (ptt)"
        ,"pte" => "Plaintiff-appellee (pte)"
        ,"plt" => "Platemaker (plt)"
        ,"pra" => "Praeses (pra)"
        ,"pre" => "Presenter (pre)"
        ,"prt" => "Printer (prt)"
        ,"pop" => "Printer of plates (pop)"
        ,"prm" => "Printmaker (prm)"
        ,"prc" => "Process contact (prc)"
        ,"pro" => "Producer (pro)"
        ,"prn" => "Production company (prn)"
        ,"prs" => "Production designer (prs)"
        ,"pmn" => "Production manager (pmn)"
        ,"prd" => "Production personnel (prd)"
        ,"prp" => "Production place (prp)"
        ,"prg" => "Programmer (prg)"
        ,"pdr" => "Project director (pdr)"
        ,"pfr" => "Proofreader (pfr)"
        ,"prv" => "Provider (prv)"
        ,"pup" => "Publication place (pup)"
        ,"pbl" => "Publisher (pbl)"
        ,"pbd" => "Publishing director (pbd)"
        ,"ppt" => "Puppeteer (ppt)"
        ,"rdd" => "Radio director (rdd)"
        ,"rpc" => "Radio producer (rpc)"
        ,"rce" => "Recording engineer (rce)"
        ,"rcd" => "Recordist (rcd)"
        ,"red" => "Redaktor (red)"
        ,"ren" => "Renderer (ren)"
        ,"rpt" => "Reporter (rpt)"
        ,"rps" => "Repository (rps)"
        ,"rth" => "Research team head (rth)"
        ,"rtm" => "Research team member (rtm)"
        ,"res" => "Researcher (res)"
        ,"rsp" => "Respondent (rsp)"
        ,"rst" => "Respondent-appellant (rst)"
        ,"rse" => "Respondent-appellee (rse)"
        ,"rpy" => "Responsible party (rpy)"
        ,"rsg" => "Restager (rsg)"
        ,"rsr" => "Restorationist (rsr)"
        ,"rev" => "Reviewer (rev)"
        ,"rbr" => "Rubricator (rbr)"
        ,"sce" => "Scenarist (sce)"
        ,"sad" => "Scientific advisor (sad)"
        ,"aus" => "Screenwriter (aus)"
        ,"scr" => "Scribe (scr)"
        ,"scl" => "Sculptor (scl)"
        ,"spy" => "Second party (spy)"
        ,"sec" => "Secretary (sec)"
        ,"sll" => "Seller (sll)"
        ,"std" => "Set designer (std)"
        ,"stg" => "Setting (stg)"
        ,"sgn" => "Signer (sgn)"
        ,"sng" => "Singer (sng)"
        ,"sds" => "Sound designer (sds)"
        ,"spk" => "Speaker (spk)"
        ,"spn" => "Sponsor (spn)"
        ,"sgd" => "Stage director (sgd)"
        ,"stm" => "Stage manager (stm)"
        ,"stn" => "Standards body (stn)"
        ,"str" => "Stereotyper (str)"
        ,"stl" => "Storyteller (stl)"
        ,"sht" => "Supporting host (sht)"
        ,"srv" => "Surveyor (srv)"
        ,"tch" => "Teacher (tch)"
        ,"tcd" => "Technical director (tcd)"
        ,"tld" => "Television director (tld)"
        ,"tlp" => "Television producer (tlp)"
        ,"ths" => "Thesis advisor (ths)"
        ,"trc" => "Transcriber (trc)"
        ,"trl" => "Translator (trl)"
        ,"tyd" => "Type designer (tyd)"
        ,"tyg" => "Typographer (tyg)"
        ,"uvp" => "University place (uvp)"
        ,"vdg" => "Videographer (vdg)"
        ,"voc" => "Vocalist (voc; deprecated, use Singer)"
        ,"vac" => "Voice actor (vac)"
        ,"wit" => "Witness (wit)"
        ,"wde" => "Wood engraver (wde)"
        ,"wdc" => "Woodcutter (wdc)"
        ,"wam" => "Writer of accompanying material (wam)"
        ,"wac" => "Writer of added commentary (wac)"
        ,"wal" => "Writer of added lyrics (wal)"
        ,"wat" => "Writer of added text (wat)"
        ,"win" => "Writer of introduction (win)"
        ,"wpr" => "Writer of preface (wpr)"
        ,"wst" => "Writer of supplementary textual content (wst)"
      ];
      foreach ($rel_types as $rel_value => $rel_label) {
        $definition = [
          'label' => $this->t('Agent By Role: ' . $rel_label),
          'description' => $this->t('An agent by role'),
          'type' => 'string',
          'processor_id' => $this->getPluginId(),
          'is_list' => TRUE
        ];
        $properties['s_islandora_linked_agent_' . $rel_value] = new ProcessorProperty($definition);
      }
    }

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function addFieldValues(ItemInterface $item) {
    $node = $item->getOriginalObject()->getValue();
    if ($node->hasField('field_linked_agent') && !$node->get('field_linked_agent')->isEmpty()) {
      $vals = $node->field_linked_agent->getValue();
      foreach ($vals as $element) {
        $fields = $item->getFields(FALSE);
        $tid = $element['target_id'];
        $taxo_term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
        if ($taxo_term) {
          $taxo_name = $taxo_term->name->value;
          $rel_type = $element['rel_type'];
          $mac_rel = strtolower($rel_type);
          $mac_rel = str_replace('relators:', '', $mac_rel);
          $fields = $this->getFieldsHelper()->filterForPropertyPath($fields, NULL, 's_islandora_linked_agent_' . $mac_rel);
          foreach ($fields as $field) {
            $field->addValue($taxo_name);
          }
        }
      }
    }
  }

}

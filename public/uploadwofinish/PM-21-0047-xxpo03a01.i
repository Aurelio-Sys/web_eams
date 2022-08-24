/* po03a01.i - PURCHASE ORDER PRINT INCLUDE FILE                              */
/* Copyright 1986 QAD Inc. All rights reserved.                               */
/* $Id::                                                                   $: */
/*                                                                            */
/* REVISION: 5.0      LAST MODIFIED: 03/28/90   BY: MLB *B615**/
/* REVISION: 6.0      LAST MODIFIED: 08/14/91   BY: RAM *D828**/
/* REVISION: 6.0      LAST MODIFIED: 11/05/91   BY: RAM *D913**/
/* REVISION: 7.3      LAST MODIFIED: 02/22/93   BY: JMS *G712**/
/* REVISION: 7.3      LAST MODIFIED: 03/29/95   BY: dzn *F0PN**/
/* REVISION: 8.6E     LAST MODIFIED: 02/23/98   BY: *L007* Annasaheb Rahane   */
/* REVISION: 8.6E     LAST MODIFIED: 05/20/98   BY: *K1Q4* Alfred Tan         */
/* REVISION: 8.6E     LAST MODIFIED: 10/04/98   BY: *J314* Alfred Tan         */
/* REVISION: 9.1      LAST MODIFIED: 07/28/99   BY: *N01B* John Corda         */
/* REVISION: 9.1      LAST MODIFIED: 07/31/00   BY: *N0GV* Mudit Mehta        */
/* Revision: 1.6.1.3    BY: Jean Miller           DATE: 12/05/01  ECO: *P039* */
/* Revision: 1.6.1.6    BY: Rajiv Ramaiah         DATE: 10/23/02  ECO: *N1XW* */
/* Revision: 1.6.1.7    BY: Ellen Borden          DATE: 01/17/06  ECO: *R008* */
/* Revision: 1.6.1.11   BY: Robin McCarth         DATE: 05/31/06  ECO: *R02F* */
/* Revision: 1.6.1.12   BY: Nivedita Banerjee     DATE: 06/25/06  ECO: *R06L* */
/*-Revision end---------------------------------------------------------------*/

/******************************************************************************/
/* All patch markers and commented out code have been removed from the source */
/* code below. For all future modifications to this file, any code which is   */
/* no longer required should be deleted and no in-line patch markers should   */
/* be added.  The ECO marker should only be included in the Revision History. */
/******************************************************************************/

/* NOTE:  This file compiles into porp0301.p                */


form
   header         skip (3)
   billto[1]      at 4
   getTermLabelRt("BANNER_PURCHASE_ORDER",38) to 80 format "x(38)"
   billto[2]      at 4
   /* DISPLAYS "SIMULATION" TEXT, IF REPORT IS RUN IN SIMULATION MODE */
   if not update_yn and po_print then
      getTermLabel("BANNER_SIMULATION",28)
   else
      ""          at 44 format "x(28)"
   billto[3]      at 4
   getTermLabelRtColon("ORDER_NUMBER",14) to 56 format "x(14)"
   po_nbr
   getTermLabelRtColon("ORDER_REVISION",10)to 76 format "x(10)"
   po_rev
   billto[4]      at 4
   getTermLabelRtColon("ORDER_DATE",14)  to 56 format "x(14)"
   po_ord_date
   getTermLabelRtColon("PAGE_OF_REPORT",10)    to 76 format "x(10)"
   string         (page-number - pages,">>9")format "x(3)"
   billto[5]      at 4
   getTermLabelRtColon("PRINT_DATE",14)  to 56 format "x(14)"
   today
   getTermLabelRtColon("ORDER_REVISION_DATE",20) to 56 format "x(20)"
   po_rev_date
   if po_sched then  getTermLabelRtColon("START_EFFECTIVE_DATE",23)
   else "" to 56 format "x(23)"
   if po_sched then
   po_eff_strt
   else ? at 58
   if po_sched then getTermLabelRtColon("END_EFFECTIVE_DATE",21)
   else "" to 56 format "x(21)"
   if po_sched then
   po_eff_to
   else ? at 58
   billto[6]      at 4
   duplicate      to 80 skip (1)
   getTermLabel("SUPPLIER",20) + ": " +
   po_vend at 8 format "x(30)"
   getTermLabel("SHIP_TO",20) + ": " +
   poship at 46 format "x(30)"  skip (1)
   vendor[1]      at 8
   shipto[1]      at 46
   vendor[2]      at 8
   shipto[2]      at 46
   vendor[3]      at 8
   shipto[3]      at 46
   vendor[4]      at 8
   shipto[4]      at 46
   vendor[5]      at 8
   shipto[5]      at 46
   vendor[6]      at 8
   shipto[6]      at 46
   /* vdattnlbl      to 17
   vdattn               skip (1)
   getTermLabelRtColon("FAX/TELEX",14)   to 54 format "x(14)"
   vend_fax
   getTermLabelRtColon("CONFIRMING",14)  to 14 format "x(14)"
   po_confirm
   getTermLabelRtColon("SUPPLIER_TELEPHONE",20) to 54 format "x(20)"
   vend_phone
   getTermLabelRtColon("BUYER",14)  to 14 format "x(14)"
   po_buyer
   getTermLabelRtColon("CONTACT",15) to 54 format "x(15)"
   po_contact
   getTermLabelRtColon("CREDIT_TERMS",14)  to 14 format "x(14)"
   po_cr_terms
   getTermLabelRtColon("SHIP_VIA",15) to 54 format "x(15)"
   po_shipvia
   " "            to 14
   termsdesc
   getTermLabelRtColon("FOB",10) to 54 format "x(10)"
   po_fob
   getTermLabelRtColon("REMARKS",14)  to 14 format "x(14)"
   po_rmks
   vatreglbl to 14
   vatreg
   skip(1)
   l_tx_misc1 at 5
   l_tx_misc2 at 30
   l_tx_misc3 at 55*/ /* Update View Print 11072019*/
with frame phead1 page-top width 90.

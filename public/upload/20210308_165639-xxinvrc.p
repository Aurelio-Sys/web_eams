/* QAD_I19_ID_TAX_status.p - Efaktur PK Status Report  (Indonesia)            */
/* Copyright 1986 QAD Inc. All rights reserved worldwide.                     */
/*                                                                            */
/* $Id: QAD_I19_ID_TAX_Status.p 28574 2019-10-17 07:13:55Z d5a $: */
/* Description: Proxy program for display Status Efaktur Tax Number           */
/* REVISION 1:         LAST MODIFIED : 12/30/2020 BY : ASTRI - PT. IMI  (shipto) */

{mfsubdirs.i}
{{&US_BBI}mfdeclre.i}
{{&US_BBI}gplabel.i}
{com/qad/shell/report/dsReportRequest.i}
{com/qad/shell/report/ReportConstants.i}

define variable descPart        as character.
define variable soPO            as character.
define variable cmmt            as character.
define variable total           as decimal.
define variable word            as character.
define variable tax 			       as character.
define variable part            as character.
define variable gr             as integer.
define variable descCountry     like CountryCode.
define variable custItemComment          LIKE cp_comment.
define variable custItemDisplay          LIKE cp_cust_partd.
define variable custItemCmtDisp          LIKE cp_cust_partd.
define variable custItemItmCmt           LIKE cp_comment.
define variable custItemItmDisp          LIKE cp_cust_partd.
define variable desc1           like pt_desc1.
define variable desc2           like pt_desc2.
define variable billto          like ad_addr.
define variable sum_qty       as decimal.

define temp-table tt_filterinv no-undo
   field pdiv_inv_nbr      like pdiv_inv_nbr
   field pdiv_cust         like pdiv_cust
   field pdivd_shipto      like pdivd_shipto
   field pdiv_inv_date     like pdiv_inv_date.

define temp-table tt_outputinv no-undo
   field tt_output_invnbr        like pdiv_mstr.pdiv_inv_nbr
   field tt_output_sonbr         like pdiv_mstr.pdiv_nbr
   field tt_output_invdate       like pdiv_mstr.pdiv_inv_date
   field tt_output_cust          like pdiv_mstr.pdiv_cust
   field tt_output_bill          like pdiv_mstr.pdiv_bill
   field tt_output_ship          like pdiv_mstr.pdiv_bill
   field tt_output_term          like pdiv_cr_terms
   field tt_output_custName      like ad_name
   field tt_output_custName2     like ad_name
   field tt_output_custName12    like ad_name
   field tt_output_custLine1     like ad_line1
   field tt_output_custLine2     like ad_line2
   field tt_output_custLine3     like ad_line3
   field tt_output_custCity      like ad_city
   field tt_output_custZip       like ad_zip
   field tt_output_custCountry   like ad_city
   field tt_output_custLine23    like ad_line2
   field tt_output_custCityZip   like ad_city
   field tt_output_custPhone     like ad_phone
   field tt_output_custFax       like ad_fax
   field tt_output_shipName      like ad_name
   field tt_output_shipName2     like ad_name
   field tt_output_shipName12    like ad_name
   field tt_output_shipLine1     like ad_line1
   field tt_output_shipLine2     like ad_line2
   field tt_output_shipLine3     like ad_line3
   field tt_output_shipCity      like ad_city
   field tt_output_shipZip       like ad_zip
   field tt_output_shipCountry   like ad_country
   field tt_output_shipLine23    like ad_line2
   field tt_output_shipCityZip   like ad_city
   field tt_output_shipPhone     like ad_phone
   field tt_output_shipFax       like ad_fax
   field tt_output_compName      like ad_name
   field tt_output_compLine1     like ad_line1
   field tt_output_compLine2     like ad_line2
   field tt_output_compLine3     like ad_line3
   field tt_output_compCity      like ad_city
   field tt_output_compZip       like ad_zip
   field tt_output_compCountry   like ad_country
   field tt_output_compLine23    like ad_line1
   field tt_output_compCityZip   like ad_city
   field tt_output_compPhone     like ad_phone
   field tt_output_compFax       like ad_fax
   field tt_output_dn            like abs_id
   field tt_output_dndate        like abs_shp_date
   field tt_output_cmmt          as character
   field tt_output_tax           as character
   field tt_output_dpp           as decimal format "->>,>>>,>>>,>>9.99"
   field tt_output_ppn           as decimal format "->>,>>>,>>>,>>9.99"
   field tt_output_totC          as decimal format "->>,>>>,>>>,>>9.99"
   field tt_output_totD          as decimal format "->>,>>>,>>>,>>9.99"
   field tt_output_qty           as decimal.

define temp-table dd_outputinv no-undo
   field dd_output_line          like pdivd_line
   field dd_output_sopo          like pdivd_po
   field dd_output_part          like pdivd_cust_part
   field dd_output_descPart      as character
   field dd_output_descPart1     like pt_desc1
   field dd_output_descPart2     like pt_desc2
   field dd_output_cust          like pdivd_cust_part
   field dd_output_custItemComment          LIKE cp_comment
   field dd_output_custItemDisplay          LIKE cp_cust_partd
   field dd_output_custItemCmtDisp          LIKE cp_cust_partd
   field dd_output_custItemItmCmt           LIKE cp_comment
   field dd_output_custItemItmDisp          LIKE cp_cust_partd
   field dd_output_qty           like pdivd_qty
   field dd_output_price         like pdivd_price
   field dd_output_invnbr        like pdiv_mstr.pdiv_inv_nbr
   field dd_output_nbr 			   like pdiv_mstr.pdiv_nbr
   field dd_output_dn            like pdivd_shipto_ref.   

define dataset dsReportResults          for tt_filterinv,tt_outputinv,dd_outputinv.
define input   parameter runReport      as  logical no-undo.
define input   parameter reportHandle   as  handle no-undo.
define input   parameter dataset        for dsReportRequest.
define output  parameter dataset-handle phReportResults.

{com/qad/shell/report/reporting.i}

define variable bufferName as character no-undo.
define variable vhds       as handle    no-undo.

empty temp-table tt_filterinv  no-error.
empty temp-table tt_outputinv  no-error.
empty temp-table dd_outputinv  no-error.

for first ttReportRequest no-lock: 
   vhds = dataset dsReportResults:handle.
   run FillMetaData in reportHandle(vhds,"xxinvrc.meta.xml").  
   run MetaDataOverride.
   if runReport then
   do: 
      run RunReport(output dataset-handle phReportResults).
   end.
end. /*for first ttReportRequest*/

PROCEDURE RunReport:  
    define output   parameter    dataset-handle phReportResults.
    define variable querystring  as  character      no-undo.
    define variable hquery       as  handle         no-undo.
    define query    invquery     for pdiv_mstr, pdivd_det.
   
    hquery = query invquery:handle.
    querystring = "for each pdiv_mstr no-lock where true and pdiv_domain = " + quoter(global_domain) + "," +
               "each pdivd_det no-lock where true and pdivd_nbr = pdiv_nbr and pdivd_domain = " + quoter(global_domain). 
               
    run FillQueryStringVariable in reportHandle (input
    "tt_filterinv", input "pdiv_inv_nbr", input-output querystring).
    run FillQueryStringVariable in reportHandle (input
    "tt_filterinv", input "pdiv_cust", input-output querystring).
    run FillQueryStringVariable in reportHandle (input
    "tt_filterinv", input "pdivd_shipto", input-output querystring).
    run FillQueryStringVariable in reportHandle (input
    "tt_filterinv", input "pdiv_inv_date", input-output querystring).
   
    querystring = querystring + ":".
    hquery:query-prepare(querystring).
    hquery:query-open().
    hquery:get-next().
    
    repeat while not hquery:query-off-end: /* query */
    find first tt_outputinv where tt_outputinv.tt_output_invnbr = pdiv_mstr.pdiv_inv_nbr no-lock no-error.
    if available(tt_outputinv) then do :
      descPart = "".
    end.
    else do : /*tt_outputinv*/
      run getComments (input pdiv_domain, output cmmt).

      create tt_outputinv.
        assign
           tt_outputinv.tt_output_invnbr    = pdiv_mstr.pdiv_inv_nbr
           tt_outputinv.tt_output_sonbr     = pdiv_mstr.pdiv_nbr
           tt_outputinv.tt_output_invdate   = pdiv_mstr.pdiv_inv_date
           tt_outputinv.tt_output_cust      = pdiv_mstr.pdiv_cust
           tt_outputinv.tt_output_bill      = pdiv_mstr.pdiv_bill
           tt_outputinv.tt_output_ship      = pdiv_mstr.pdiv_bill
           tt_outputinv.tt_output_term      = pdiv_mstr.pdiv_cr_terms
           tt_outputinv.tt_output_cmmt      = cmmt. 

      billto = pdiv_mstr.pdiv_bill.

      /*============sold-to address=========*/
      find first ad_mstr where ad_domain = global_domain
        and ad_addr = pdiv_mstr.pdiv_bill no-lock no-error.
      if available(ad_mstr) then do :          
        for each businessrelation where businessrelationcode = ad_bus_relation no-lock,
          each address of businessrelation no-lock,
          each addresstype of address where addresstypecode = 'remittance' no-lock :
        
            find first country where country.Country_ID = address.Country_ID no-lock no-error.
            if available(country) then do :
              descCountry   = CountryCode.
            end.

            assign /* Sold to */
            tt_output_custName      = AddressName
            tt_output_custName2     = BusinessRelationName2
            tt_output_custName12    = AddressName + " " + BusinessRelationName2
            tt_output_custLine1     = AddressStreet1
            tt_output_custLine2     = AddressStreet2
            tt_output_custLine3     = AddressStreet3
            tt_output_custCity      = AddressCity
            tt_output_custZip       = AddressZip
            tt_output_custCountry   = descCountry
            tt_output_custPhone     = AddressTelephone
            tt_output_custFax       = AddressFax
            tt_output_custLine23    = AddressStreet2 + " " + AddressStreet3
            tt_output_custCityZip   = AddressCity + ", " + AddressZip
            tt_output_tax           = substr(AddressTaxIDState,1,2) + "." + substr(AddressTaxIDState,3,3) + "." + substr(AddressTaxIDState,6,3) + "." + substr(AddressTaxIDState,9,1) + "-" + substr(AddressTaxIDState,10,3) + "." + substr(AddressTaxIDState,13,3).
        end.
      END.

      /*============Company address=========*/
      find first ls_mstr where ls_domain = global_domain 
        and ls_type = "company" no-lock no-error.
      if available(ls_mstr) then do :
        find first ad_mstr where ad_domain = global_domain
          and ad_addr = ls_addr no-lock no-error.
        if available(ad_mstr) then do :
          find first address where address_id = ad_address_id no-lock no-error.
          if available(address) then do :
            find first country where country.Country_ID = address.Country_ID no-lock no-error.
            if available(country) then do :
              descCountry   = CountryDescription.
            end.

            assign
              tt_output_compName     = AddressName
              tt_output_compLine1    = AddressStreet1
              tt_output_compLine2    = AddressStreet2
              tt_output_compLine3    = AddressStreet3
              tt_output_compCity     = AddressCity
              tt_output_compZip      = AddressZip
              tt_output_compLine23   = AddressStreet2 + " " + AddressStreet3
              tt_output_compCityZip  = AddressCity + ", " + AddressZip
              tt_output_compCountry  = descCountry
              tt_output_compPhone    = AddressTelephone
              tt_output_compFax      = AddressFax.
          END.
        END.
      END.

      /* ship-to */
      find first cm_mstr where cm_domain = global_domain 
           and cm_addr = pdivd_shipto no-lock no-error.
      if available cm_mstr then do:
         find first ad_mstr where ad_domain = global_domain
              and ad_addr = pdivd_shipto no-lock no-error.
         if available ad_mstr then do :
            for each businessrelation where businessrelationcode = ad_bus_relation no-lock,
                each address of businessrelation no-lock,
                each addresstype of address where addresstypecode = 'remittance' no-lock :

                find first country where country.Country_ID = address.Country_ID no-lock no-error.
                if available country then 
                   descCountry   = CountryCode.
                else descCountry = "".
                
                assign
                  tt_output_shipName     = AddressName
                  tt_output_shipName2    = BusinessRelationName2
                  tt_output_shipName12   = AddressName + " " + BusinessRelationName2
                  tt_output_shipLine1    = AddressStreet1
                  tt_output_shipLine2    = AddressStreet2
                  tt_output_shipLine3    = AddressStreet3
                  tt_output_shipCity     = AddressCity
                  tt_output_shipZip      = AddressZip
                  tt_output_shipLine23   = AddressStreet2 + " " + AddressStreet3
                  tt_output_shipCityZip  = AddressCity + ", " + AddressZip
                  tt_output_shipCountry  = descCountry
                  tt_output_shipPhone    = AddressTelephone
                  tt_output_shipFax      = AddressFax.
            end.  /* for each businessrelation */
         end.     /* available ad_mstr */  
      end.        /* available cm_mstr */
      else do:   /* sold-to <> ship-to */                   
         find first ad_mstr where ad_domain = global_domain 
              and ad_addr = pdivd_shipto no-lock no-error.
         if available ad_mstr then do :
            find first businessrelation where businessrelationcode = ad_bus_relation
                 no-lock no-error.
            if available businessrelation then
              assign
                  tt_output_shipName2     = BusinessRelationName2
                  tt_output_shipName12    = ad_name + " " + BusinessRelationName2.
            else
                assign
                    tt_output_shipName12    = ad_name.

            assign
                tt_output_shipName      = ad_name
                tt_output_shipLine1     = ad_line1
                tt_output_shipLine2     = ad_line2
                tt_output_shipLine3     = ad_line3
                tt_output_shipCity      = ad_city
                tt_output_shipZip       = ad_zip
                tt_output_shipCountry   = ad_country
                tt_output_shipLine23    = ad_line2 + " " + ad_line3
                tt_output_shipCityZip   = ad_city + ", " + ad_zip
                tt_output_shipPhone     = ad_phone
                tt_output_shipFax       = ad_fax.
         end.
      end.    /* end of sold-to <> ship-to */
      /* end of ship-to logic */

    /* Invoice Amount */                         
    for each dinvoice where dinvoiceditext = pdiv_mstr.pdiv_nbr                         
          and dinvoicevoucher = int(substr(pdiv_mstr.pdiv_inv_nbr,14,9))                          
          and dinvoicedate = pdiv_mstr.pdiv_inv_date                                                
          no-lock :                          
          
          assign
            tt_output_dpp 	= DInvoiceVatBaseCreditTC
            tt_output_ppn 	= DInvoiceVatcreditTC
            tt_output_totC 	= DInvoiceBalanceCreditTC
            tt_output_totD 	= DInvoiceBalanceDebitTC.                                                                            
    end.       

    /* Detail */
    sum_qty = 0.
    for each pdivd_det where pdivd_domain = global_domain
      and pdivd_nbr = pdiv_nbr no-lock :
         
      part = pdivd_cust_part.

      find first cp_mstr where cp_domain = global_domain
        and cp_cust_part = pdivd_cust_part
        and cp_cust = billto no-lock no-error.
      if available(cp_mstr) then do :
        part 			        = cp_part.
        custItemComment   = cp_comment.
        custItemDisplay   = cp_cust_partd.
        custItemCmtDisp   = cp_comment + " " + cp_cust_partd.
        custItemItmCmt    = cp_cust_part + " " + cp_comment.
        custItemItmDisp   = cp_cust_part + " " + cp_cust_partd.
      end.
      else do :
        custItemComment   = "". 
        custItemDisplay   = "". 
        custItemCmtDisp   = "". 
        custItemItmCmt    = "". 
        custItemItmDisp   = "". 
      end.

      find first pt_mstr where pt_domain = global_domain
        and pt_part = part no-lock no-error.
      if available(pt_mstr) then do :
      /*displaytextmessage(part,3).*/
        descPart = pt_desc1 + " " + pt_desc2.
        desc1    = pt_desc1.
        desc2    = pt_desc2.
      end.
      else do :
        descPart = "".
        desc1    = "".
        desc2    = "".
      end.
         
      find first so_mstr where so_domain = global_domain
        and so_nbr = pdivd_nbr no-lock no-error.
      if available(so_mstr) then
        soPO = so_po.
      else
        soPO = "".

      sum_qty = sum_qty + pdivd_qty.

      create dd_outputinv.
      assign
         dd_output_line               = pdivd_line
         dd_output_sopo               = pdivd_po
         dd_output_part               = part
         dd_output_descPart           = descPart
         dd_output_descPart1          = desc1
         dd_output_descPart1          = desc2
         dd_output_cust               = pdivd_cust_part
         dd_output_custItemComment    = custItemComment
         dd_output_custItemCmtDisp    = custItemCmtDisp
         dd_output_custItemDisplay    = custItemDisplay
         dd_output_custItemItmCmt     = custItemItmCmt
         dd_output_custItemItmDisp    = custItemItmDisp 
         dd_output_qty                = pdivd_qty
         dd_output_price              = pdivd_price
         dd_output_invnbr             = pdiv_mstr.pdiv_inv_nbr
         dd_output_nbr 		            = soPO
         dd_output_dn                 = pdivd_shipto_ref.
    END.

    assign
      tt_output_qty   = sum_qty.
  end.
      
        hquery:get-next().  
    end. /* Repeat query */   
   
  phReportResults = dataset dsreportresults:handle.       
END PROCEDURE. /*run report*/

PROCEDURE MetaDataOverride :    
   run SetFieldMetaParameter in reportHandle ("tt_filterinv",
                                              "pdiv_inv_nbr",
                                              "lookupName",
                                              "xxlu507.p"). /* tambahkan field pdiv_inv_nbr di browse defaultnya */
END PROCEDURE. /*MetaDataOverride*/

PROCEDURE getComments:

   define input parameter commentDomain as character no-undo.
   define output parameter commentText as character no-undo.

   define variable maxLine as integer no-undo.
   define variable i as integer no-undo.
   define variable newLineAdded as logical no-undo.
   define variable firstPage as logical initial yes no-undo.

    for each cd_det no-lock where cd_domain = commentDomain
   and cd_ref = "bank" : 
   
      do maxLine = 15 to 1 by -1:
         if trim(cd_cmmt[maxLine]) <> "" then leave.
      end.

      if firstPage = no and newLineAdded = no 
      then assign newLineAdded = yes
                   commentText = commentText + "~n".   

      do i = 1 to maxLine:
    commentText = commentText + cd_cmmt[i] + "~n" .


         /*/* Start a new line or append the next line of detail? */
         if trim(commentText) <> "" and newLineAdded = no
         and substring(cmt_cmmt[i],1,1) = " "
         then assign newLineAdded = yes 
                      commentText = commentText + "~n".  

         if trim(cmt_cmmt[i]) <> "" then do:
            if newLineAdded or trim(commentText) = ""
            then commentText = commentText + cmt_cmmt[i].
            else commentText = commentText + " " + cmt_cmmt[i].
            newLineAdded = no.
         end.
         else assign newLineAdded = yes  
                      commentText = commentText + "~n".*/
      end.

      firstPage = no. 
   end.
   
END PROCEDURE. /* getComments */
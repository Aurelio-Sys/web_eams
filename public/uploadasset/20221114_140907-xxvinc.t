/* xxvinc.t - CREATE TRIGGER FOR TABLE xxvin_mstr                             */
/* REVISION: 1.0       LAST MODIFIED: 10/11/22       BY:                      */
/*----------------------------------------------------------------------------*/

TRIGGER PROCEDURE FOR CREATE OF xxvin_mstr.

{us/gp/gpoidfcn.i} /* Contains nextOidValue function */

{us/gp/gpoidcr.i &TABLE-NAME=xxvin_mstr}

<?php
/**
 * Auction Affiliate v1.0
 * http://www.auctionaffiliate.co
 *
 * By Joseph Hawes
 * http://www.josephhawes.co.uk
 */
eval(base64_decode('Y2xhc3MgQXVjdGlvbkFmZmlsaWF0ZSB7cHJpdmF0ZSAkc2V0dGluZ3M7cHJpdmF0ZSAkcmVxdWVzdF9wYXJhbWV0ZXJzO3ByaXZhdGUgJHJlcXVlc3Q7cHJpdmF0ZSAkcmVzcG9uc2U7cHJpdmF0ZSAkaHRtbF9vdXRwdXQ7cHJpdmF0ZSAkYUhhc2g7cHJpdmF0ZSAkaG9zdG5hbWU7ZnVuY3Rpb24gX19jb25zdHJ1Y3QoKSB7JHRoaXMtPnNldHRpbmdzID0gYXJyYXkoJ2h0bWxfb3V0cHV0X2lkX3ByZWZpeCcgPT4gJ2F1Y3Rpb24tYWZmaWxpYXRlLScsJ2h0bWxfb3V0cHV0X3ByZWZpeCcgPT4gJ2FhLScsJ3N0eWxlc2hlZXRfdXJsJyA9PiAnaHR0cDovL3d3dy5hdWN0aW9uYWZmaWxpYXRlLmNvL2Fzc2V0cy90aGVtZS9jc3MvdGhlbWVzLmNzcycsJ3JlcXVlc3RfZW5kcG9pbnQnID0+ICdodHRwOi8vd3d3LmF1Y3Rpb25hZmZpbGlhdGUuY28vaXRlbXMvZ2V0LycsJ3JlcXVlc3RfcGFyYW1ldGVyX2dyb3VwcycgPT4gYXJyYXkoJ2tleXdvcmQnICA9PiBhcnJheSgnbmFtZScgPT4gJ0tleXdvcmQgUXVlcnknLCdkZXNjcmlwdGlvbicgPT4gJ1N0YXJ0IGJ5IGVudGVyaW5nIHlvdXIga2V5d29yZCBxdWVyeSBhbmQgeW91ciBlUE4gY2FtcGFpZ24gSUQuIFRoaXMgZGV0ZXJtaW5lcyB3aGljaCBpdGVtcyBhcmUgcHVsbGVkIGZyb20gZUJheSBhbmQgZW5zdXJlcyBsaW5rcyB0byBlQmF5IGFyZSBjcmVkaXRlZCB0byB5b3UuJyksJ2FmZmlsaWF0ZScgID0+IGFycmF5KCduYW1lJyA9PiAnQWZmaWxpYXRlIERldGFpbHMnLCdkZXNjcmlwdGlvbicgPT4gJ0FkZGl0aW9uYWwgZUJheSBQYXJ0bmVyIE5ldHdvcmsgZGV0YWlscy4gWW91IGNhbiBhbHNvIGNob29zZSB3aGljaCBlQmF5IHNpdGUgeW91ciBpdGVtcyBhcmUgcHVsbGVkIGZyb20gYW5kIHdoaWNoIHNpdGUgeW91IGxpbmsgdG8uJyksJ2l0ZW1zJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdJdGVtIE9wdGlvbnMnLCdkZXNjcmlwdGlvbicgPT4gJ1VzZSB0aGVzZSBvcHRpb25zIHRvIHNwZWNpZnkgaXRlbSBmaWx0ZXJzIGJhc2VkIG9uIGxpc3RpbmcgdHlwZSwgY29uZGl0aW9uIGFuZCBwcmljZSByYW5nZS4nKSwnZGlzcGxheScgID0+IGFycmF5KCduYW1lJyA9PiAnRGlzcGxheSBPcHRpb25zJywnZGVzY3JpcHRpb24nID0+ICdIb3cgbWFueSBpdGVtcyB0byBkaXNwbGF5IG9uIHlvdXIgcGFnZSwgaW4gd2hpY2ggb3JkZXIgYW5kIGhvdyB0aGV5IGFyZSBzdHlsZWQuJyksJ2FkdmFuY2VkJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdBZHZhbmNlZCcsJ2Rlc2NyaXB0aW9uJyA9PiAnQWR2YW5jZWQgaXRlbSBvcHRpb25zIHN1Y2ggYXMgY2F0ZWdvcnkgYW5kIHNwZWNpZmljIHNlbGxlciBmaWx0ZXJzLiAnKSksJ3JlcXVlc3RfcGFyYW1ldGVyX2RlZmluaXRpb25zJyA9PiBhcnJheSgnZUtleXdvcmQnICA9PiBhcnJheSgnbmFtZScgPT4gJ2VLZXl3b3JkJywnaWQnID0+ICdlS2V5d29yZCcsJ3RpcCcgPT4gJ1RoZSBrZXl3b3JkcyB3aGljaCBkZXRlcm1pbmUgd2hpY2ggaXRlbXMgdG8gZGlzcGxheSwgc2ltaWxhciB0byBhIHNlYXJjaCBvbiB0aGUgYWN0dWFsIGVCYXkgc2l0ZS4gQWNjZXB0cyBzb21lIGFkdmFuY2VkIG9wZXJhdG9ycyAvIHB1bmN0dWF0aW9uLiBTZWUgZG9jdW1lbnRhdGlvbiBmb3IgbW9yZSBkZXRhaWxzLicsJ2dyb3VwJyA9PiAna2V5d29yZCcsJ3RpdGxlJyA9PiAnSXRlbSBTZWFyY2ggUXVlcnknKSwnZUNhbXBJRCcgID0+IGFycmF5KCduYW1lJyA9PiAnZUNhbXBJRCcsJ2lkJyA9PiAnZUNhbXBJRCcsJ3RpcCcgPT4gJ0EgY2FtcGFpZ24gaWRlbnRpZmllciBsaW5rZWQgdG8geW91ciBlQmF5IFBhcnRuZXIgTmV0d29yayBhY2NvdW50LicsJ2dyb3VwJyA9PiAna2V5d29yZCcsJ3RpdGxlJyA9PiAnZVBOIENhbXBhaWduIElEJyksJ2VTaXRlJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlU2l0ZScsJ2lkJyA9PiAnZVNpdGUnLCd0aXAnID0+ICdUaGUgZUJheSBzaXRlIGZyb20gd2hpY2ggaXRlbXMgd2lsbCBiZSBkaXNwbGF5ZWQuIFRoaXMgYWxzbyBkZXRlcm1pbmVzIHdoaWNoIHNpdGUgaXRlbSBsaW5rcyB3aWxsIHBvaW50IHRvLicsJ3R5cGUnID0+ICdzZWxlY3QnLCdvcHRpb25zJyA9PiBhcnJheSgnMScgPT4gJ2VCYXkgVVMnLCcyJyA9PiAnZUJheSBJRScsJzMnID0+ICdlQmF5IEFUJywnNCcgPT4gJ2VCYXkgQVUnLCc1JyA9PiAnZUJheSBCRScsJzcnID0+ICdlQmF5IENBJywnMTAnID0+ICdlQmF5IEZSJywnMTEnID0+ICdlQmF5IERFJywnMTInID0+ICdlQmF5IElUJywnMTMnID0+ICdlQmF5IEVTJywnMTQnID0+ICdlQmF5IENIJywnMTUnID0+ICdlQmF5IFVLJywnMTYnID0+ICdlQmF5IE5MJyksJ2RlZmF1bHQnID0+ICcxJywnZ3JvdXAnID0+ICdhZmZpbGlhdGUnLCd0aXRsZScgPT4gJ2VCYXkgU2l0ZScpLCdlQ3VzdG9tSUQnICA9PiBhcnJheSgnbmFtZScgPT4gJ2VDdXN0b21JRCcsJ2lkJyA9PiAnZUN1c3RvbUlEJywndGlwJyA9PiAnQSB0ZXh0dWFsIGlkZW50aWZpZXIgdXNlZCBmb3IgcmVwb3J0aW5nIGluIHlvdXIgRVBOIGFjY291bnQuJywnZ3JvdXAnID0+ICdhZmZpbGlhdGUnLCd0aXRsZScgPT4gJ2VQTiBDdXN0b20gSUQnKSwnYUdlbycgID0+IGFycmF5KCduYW1lJyA9PiAnYUdlbycsJ2lkJyA9PiAnYUdlbycsJ3RpcCcgPT4gJ1doZW4gZW5hYmxlZCwgdGhpcyBvcHRpb24gZGV0ZWN0cyB0aGUgdmlzaXRvclwncyBsb2NhdGlvbiB1c2luZyB0aGVpciBJUCBhZGRyZXNzIGFuZCBhdXRvbWF0aWNhbGx5IHNldHMgdGhlIGFwcHJvcHJpYXRlIGVCYXkgU2l0ZSwgb3ZlcnJpZGluZyB0aGUgZUJheSBTaXRlIG9wdGlvbi4gSWYgdGhlIHZpc2l0b3JcJ3MgbG9jYXRpb24gY2FuIG5vdCBiZSBkZXRlcm1pbmVkIHRoZW4gdGhlIGVCYXkgU2l0ZSBvcHRpb24gd2lsbCBiZSB1c2VkLicsJ3R5cGUnID0+ICdjaGVja2JveCcsJ3ZhbHVlJyA9PiAndHJ1ZScsJ2dyb3VwJyA9PiAnYWZmaWxpYXRlJywndGl0bGUnID0+ICdHZW9ncmFwaGljYWwgSVAgVGFyZ2V0aW5nJyksJ2VTZWFyY2hEZXNjJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlU2VhcmNoRGVzYycsJ2lkJyA9PiAnZVNlYXJjaERlc2MnLCd0aXAnID0+ICdQZXJmb3JtIGl0ZW0gc2VhcmNoIHF1ZXJ5IG9uIHRoZSBpdGVtXCdzIHRpdGxlIGFuZCBkZXNjcmlwdGlvbiB0ZXh0LicsJ3R5cGUnID0+ICdyYWRpbycsJ29wdGlvbnMnID0+IGFycmF5KCdmYWxzZScgPT4gJ05vJywndHJ1ZScgPT4gJ1llcycpLCdkZWZhdWx0JyA9PiAnZmFsc2UnLCdncm91cCcgPT4gJ2l0ZW1zJywndGl0bGUnID0+ICdTZWFyY2ggVGl0bGUgYW5kIERlc2NyaXB0aW9uJyksJ2VMaXN0aW5nVHlwZScgID0+IGFycmF5KCduYW1lJyA9PiAnZUxpc3RpbmdUeXBlJywnaWQnID0+ICdlTGlzdGluZ1R5cGUnLCd0aXAnID0+ICdEaXNwbGF5IG9ubHkgYSBjZXJ0YWluIGxpc3RpbmcgdHlwZS4nLCd0eXBlJyA9PiAnc2VsZWN0Jywnb3B0aW9ucycgPT4gYXJyYXkoJ0FsbCcgPT4gJ0FsbCBMaXN0aW5ncycsJ0F1Y3Rpb24nID0+ICdBdWN0aW9uIE9ubHknLCdBdWN0aW9uV2l0aEJJTicgPT4gJ0F1Y3Rpb24gV2l0aCBCSU4nLCdGaXhlZFByaWNlJyA9PiAnQklOIE9ubHknKSwnZGVmYXVsdCcgPT4gJ0FsbCcsJ2dyb3VwJyA9PiAnaXRlbXMnLCd0aXRsZScgPT4gJ0xpc3RpbmcgVHlwZScpLCdlQ29uZGl0aW9uJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlQ29uZGl0aW9uJywnaWQnID0+ICdlQ29uZGl0aW9uJywndGlwJyA9PiAnT25seSBkaXNwbGF5IGl0ZW1zIHdoaWNoIGFyZSBvZiBhIGNlcnRhaW4gY29uZGl0aW9uLicsJ3R5cGUnID0+ICdzZWxlY3QnLCdvcHRpb25zJyA9PiBhcnJheSgnJyA9PiAnQW55JywnTmV3JyA9PiAnTmV3JywnVXNlZCcgPT4gJ1VzZWQnKSwnZ3JvdXAnID0+ICdpdGVtcycsJ3RpdGxlJyA9PiAnQ29uZGl0aW9uIEZpbHRlcicpLCdlTWluUHJpY2UnICA9PiBhcnJheSgnbmFtZScgPT4gJ2VNaW5QcmljZScsJ2lkJyA9PiAnZU1pblByaWNlJywndGlwJyA9PiAnT25seSBkaXNwbGF5IGl0ZW1zIGFib3ZlIHRoaXMgcHJpY2UuJywnZ3JvdXAnID0+ICdpdGVtcycsJ3RpdGxlJyA9PiAnTWluaW11bSBQcmljZScpLCdlTWF4UHJpY2UnICA9PiBhcnJheSgnbmFtZScgPT4gJ2VNYXhQcmljZScsJ2lkJyA9PiAnZU1heFByaWNlJywndGlwJyA9PiAnT25seSBkaXNwbGF5IGl0ZW1zIGJlbG93IHRoaXMgcHJpY2UuJywnZ3JvdXAnID0+ICdpdGVtcycsJ3RpdGxlJyA9PiAnTWF4aW11bSBQcmljZScpLCdhVGhlbWUnICA9PiBhcnJheSgnbmFtZScgPT4gJ2FUaGVtZScsJ2lkJyA9PiAnYVRoZW1lJywndGlwJyA9PiAnRGV0ZXJtaW5lcyBob3cgdGhlIGl0ZW1zIHdpbGwgYmUgZGlzcGxheWVkIG9uIHRoZSBwYWdlLiBUaGVyZSBhcmUgYSB2YXJpZXR5IG9mIHRoZW1lcyB0byBjaG9vc2UgZnJvbS4nLCd0eXBlJyA9PiAnc2VsZWN0Jywnb3B0aW9ucycgPT4gYXJyYXkoJ2RlZmF1bHQnID0+ICdEZWZhdWx0JywnZmFuY3knID0+ICdGYW5jeScsJ2NvbHVtbicgPT4gJ0NvbHVtbicsJ2dyaWQnID0+ICdHcmlkJywndW5pdmVyc2FsJyA9PiAnVW5pdmVyc2FsJywndW5zdHlsZWQnID0+ICdVbnN0eWxlZCcpLCdkZWZhdWx0JyA9PiAnZGVmYXVsdCcsJ2dyb3VwJyA9PiAnZGlzcGxheScsJ3RpdGxlJyA9PiAnVGhlbWUnKSwnZVNvcnRPcmRlcicgID0+IGFycmF5KCduYW1lJyA9PiAnZVNvcnRPcmRlcicsJ2lkJyA9PiAnZVNvcnRPcmRlcicsJ3RpcCcgPT4gJ1RoZSBvcmRlciBpbiB3aGljaCBpdGVtcyB3aWxsIGJlIGRpc3BsYXllZC4nLCd0eXBlJyA9PiAnc2VsZWN0Jywnb3B0aW9ucycgPT4gYXJyYXkoJ0Jlc3RNYXRjaCcgPT4gJ0Jlc3QgTWF0Y2gnLCdFbmRUaW1lU29vbmVzdCcgPT4gJ0l0ZW1zIEVuZGluZyBGaXJzdCcsJ1N0YXJ0VGltZU5ld2VzdCcgPT4gJ05ld2x5LUxpc3RlZCBJdGVtcyBGaXJzdCcsJ1ByaWNlUGx1c1NoaXBwaW5nTG93ZXN0JyA9PiAnTG93ZXN0IEZpcnN0JywnUHJpY2VQbHVzU2hpcHBpbmdIaWdoZXN0JyA9PiAnSGlnaGVzdCBGaXJzdCcpLCdkZWZhdWx0JyA9PiAnRW5kVGltZVNvb25lc3QnLCdncm91cCcgPT4gJ2Rpc3BsYXknLCd0aXRsZScgPT4gJ09yZGVyIEl0ZW1zIEJ5JyksJ2FEaXNwTG9nbycgID0+IGFycmF5KCduYW1lJyA9PiAnYURpc3BMb2dvJywnaWQnID0+ICdhRGlzcExvZ28nLCd0aXAnID0+ICdEZXRlcm1pbmVzIGlmIHRoZSBSaWdodCBOb3cgT24gZUJheSBsb2dvIHdpbGwgYmUgZGlzcGxheWVkIGFib3ZlIGl0ZW1zLicsJ3R5cGUnID0+ICdyYWRpbycsJ29wdGlvbnMnID0+IGFycmF5KCd0cnVlJyA9PiAnWWVzJywnZmFsc2UnID0+ICdObycpLCdkZWZhdWx0JyA9PiAndHJ1ZScsJ3ZhbHVlJyA9PiAndHJ1ZScsJ2dyb3VwJyA9PiAnZGlzcGxheScsJ3RpdGxlJyA9PiAnRGlzcGxheSBlQmF5IExvZ28nKSwnZUNvdW50JyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlQ291bnQnLCdpZCcgPT4gJ2VDb3VudCcsJ3RpcCcgPT4gJ0hvdyBtYW55IGl0ZW1zIHRvIGRpc3BsYXkgb24gZWFjaCBwYWdlLicsJ2RlZmF1bHQnID0+ICcxMCcsJ2dyb3VwJyA9PiAnZGlzcGxheScsJ3RpdGxlJyA9PiAnSXRlbXMgUGVyIFBhZ2UnKSwnYUNvbHVtbnMnICA9PiBhcnJheSgnbmFtZScgPT4gJ2FDb2x1bW5zJywnaWQnID0+ICdhQ29sdW1ucycsJ3RpcCcgPT4gJ1VzZWQgdG8gZGV0ZXJtaW5lIGhvdyBtYW55IGNvbHVtbnMgb2YgaXRlbXMgYXJlIGRpc3BsYXllZC4nLCdkZWZhdWx0JyA9PiAnMycsJ2dyb3VwJyA9PiAnZGlzcGxheScsJ3RpdGxlJyA9PiAnTnVtYmVyIE9mIENvbHVtbnMnKSwnYVdpZHRoJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdhV2lkdGgnLCdpZCcgPT4gJ2FXaWR0aCcsJ3RpcCcgPT4gJ0lmIHNwZWNpZmllZCwgYW55IG91dHB1dCB3aWxsIG5vdCBleGNlZWQgdGhpcyB3aWR0aCBvbiB5b3VyIHBhZ2UuJywnZ3JvdXAnID0+ICdkaXNwbGF5JywndGl0bGUnID0+ICdNYXhpbXVtIE91dHB1dCBXaWR0aCcpLCdhQ29sb3VyUCcgID0+IGFycmF5KCduYW1lJyA9PiAnYUNvbG91clAnLCdpZCcgPT4gJ2FDb2xvdXJQJywndGlwJyA9PiAnU3BlY2lmeSB0aGUgcHJpbWFyeSB0aGVtZSBjb2xvdXIgZm9yIGJldHRlciBpbnRlZ3JhdGlvbiBvbiB5b3VyIHNpdGUuJywnZ3JvdXAnID0+ICdkaXNwbGF5JywndGl0bGUnID0+ICdUaGVtZSBQcmltYXJ5IENvbG91cicpLCdhQ29sb3VyUycgID0+IGFycmF5KCduYW1lJyA9PiAnYUNvbG91clMnLCdpZCcgPT4gJ2FDb2xvdXJTJywndGlwJyA9PiAnU3BlY2lmeSB0aGUgc2Vjb25kYXJ5IHRoZW1lIGNvbG91ciBmb3IgYmV0dGVyIGludGVncmF0aW9uIG9uIHlvdXIgc2l0ZS4nLCdncm91cCcgPT4gJ2Rpc3BsYXknLCd0aXRsZScgPT4gJ1RoZW1lIFNlY29uZGFyeSBDb2xvdXInKSwnYUNvbG91ckInICA9PiBhcnJheSgnbmFtZScgPT4gJ2FDb2xvdXJCJywnaWQnID0+ICdhQ29sb3VyQicsJ3RpcCcgPT4gJ1NwZWNpZnkgdGhlIGJhY2tncm91bmQgdGhlbWUgY29sb3VyIGZvciBiZXR0ZXIgaW50ZWdyYXRpb24gb24geW91ciBzaXRlLicsJ2dyb3VwJyA9PiAnZGlzcGxheScsJ3RpdGxlJyA9PiAnVGhlbWUgQmFja2dyb3VuZCBDb2xvdXInKSwnZUNhdGVnb3J5SW5jJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlQ2F0ZWdvcnlJbmMnLCdpZCcgPT4gJ2VDYXRlZ29yeUluYycsJ3RpcCcgPT4gJ0EgY29tbWEgc2VwYXJhdGVkIGxpc3Qgb2YgZUJheSBjYXRlZ29yaWVzIHRvIGluY2x1ZGUgaXRlbXMgZnJvbS4gU2VlIGRvY3VtZW50YXRpb24gZm9yIGRldGFpbHMgb2YgaG93IHRvIG9idGFpbiBjYXRlZ29yeSBJRHMuJywnZ3JvdXAnID0+ICdhZHZhbmNlZCcsJ3RpdGxlJyA9PiAnQ2F0ZWdvcnkgSW5jbHVkZScpLCdlQ2F0ZWdvcnlFeGNsJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlQ2F0ZWdvcnlFeGNsJywnaWQnID0+ICdlQ2F0ZWdvcnlFeGNsJywndGlwJyA9PiAnQSBjb21tYSBzZXBhcmF0ZWQgbGlzdCBvZiBlQmF5IGNhdGVnb3JpZXMgdG8gZXhjbHVkZSBpdGVtcyBmcm9tLiBTZWUgZG9jdW1lbnRhdGlvbiBmb3IgZGV0YWlscyBvZiBob3cgdG8gb2J0YWluIGNhdGVnb3J5IElEcy4nLCdncm91cCcgPT4gJ2FkdmFuY2VkJywndGl0bGUnID0+ICdDYXRlZ29yeSBFeGNsdWRlJyksJ2VTZWxsZXJJZCcgID0+IGFycmF5KCduYW1lJyA9PiAnZVNlbGxlcklkJywnaWQnID0+ICdlU2VsbGVySWQnLCd0aXAnID0+ICdPbmx5IGRpc3BsYXkgaXRlbXMgZnJvbSBhIHNwZWNpZmljIHNlbGxlci4nLCdncm91cCcgPT4gJ2FkdmFuY2VkJywndGl0bGUnID0+ICdTZWxsZXIgSUQnKSwnZVRvcFJhdGVkJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlVG9wUmF0ZWQnLCdpZCcgPT4gJ2VUb3BSYXRlZCcsJ3RpcCcgPT4gJ09ubHkgZGlzcGxheSBpdGVtcyBsaXN0ZWQgYnkgYSBzZWxsZXIgd2l0aCBUb3AtcmF0ZWQgc2VsbGVyIHN0YXR1cy4nLCd0eXBlJyA9PiAnY2hlY2tib3gnLCd2YWx1ZScgPT4gJ3RydWUnLCdncm91cCcgPT4gJ2FkdmFuY2VkJywndGl0bGUnID0+ICdUb3AgUmF0ZWQgU2VsbGVycyBPbmx5JyksJ2VGcmVlU2hpcCcgID0+IGFycmF5KCduYW1lJyA9PiAnZUZyZWVTaGlwJywnaWQnID0+ICdlRnJlZVNoaXAnLCd0aXAnID0+ICdPbmx5IGRpc3BsYXkgaXRlbXMgd2l0aCBhIGZyZWUgc2hpcHBpbmcgb3B0aW9uLicsJ3R5cGUnID0+ICdjaGVja2JveCcsJ3ZhbHVlJyA9PiAndHJ1ZScsJ2dyb3VwJyA9PiAnYWR2YW5jZWQnLCd0aXRsZScgPT4gJ0ZyZWUgU2hpcHBpbmcgT25seScpLCdlUGF5cGFsJyAgPT4gYXJyYXkoJ25hbWUnID0+ICdlUGF5cGFsJywnaWQnID0+ICdlUGF5cGFsJywndGlwJyA9PiAnT25seSBkaXNwbGF5IGl0ZW1zIHdoaWNoIGFjY2VwdCBQYXlwYWwgYXMgYSBwYXltZW50IG1ldGhvZC4nLCd0eXBlJyA9PiAnY2hlY2tib3gnLCd2YWx1ZScgPT4gJ1BheVBhbCcsJ2dyb3VwJyA9PiAnYWR2YW5jZWQnLCd0aXRsZScgPT4gJ1BheXBhbCBBY2NlcHRlZCBPbmx5JykpKTskdGhpcy0+c2V0X2hvc3RuYW1lKCk7JHRoaXMtPmNoZWNrX2hvc3RuYW1lX2FsbG93ZWQoKTt9ZnVuY3Rpb24gZ2V0X3NldHRpbmdzKCkge3JldHVybiAkdGhpcy0+c2V0dGluZ3M7fWZ1bmN0aW9uIGdldF9jdXJyZW50X3VybCgpIHsgICR1cmwgID0gQCggJF9TRVJWRVJbIkhUVFBTIl0gIT0gJ29uJyApID8gJ2h0dHA6Ly8nLiRfU0VSVkVSWyJTRVJWRVJfTkFNRSJdIDogICdodHRwczovLycuJF9TRVJWRVJbIlNFUlZFUl9OQU1FIl07ICAkdXJsIC49ICggJF9TRVJWRVJbIlNFUlZFUl9QT1JUIl0gIT09IDgwICkgPyAiOiIuJF9TRVJWRVJbIlNFUlZFUl9QT1JUIl0gOiAiIjsgICR1cmwgLj0gJF9TRVJWRVJbIlJFUVVFU1RfVVJJIl07ICByZXR1cm4gJHVybDt9ZnVuY3Rpb24gYWRkX3F1ZXJ5X2FyZygkdXJsID0gZmFsc2UsICRhcmdzID0gYXJyYXkoKSkgeyAgaWYoISAkdXJsKSB7ICAkdXJsICA9ICR0aGlzLT5nZXRfY3VycmVudF91cmwoKTsgICAgfSR1cmxfcGFyc2VkID0gcGFyc2VfdXJsKCR1cmwpO2lmKGFycmF5X2tleV9leGlzdHMoJ3F1ZXJ5JywgJHVybF9wYXJzZWQpKSB7cGFyc2Vfc3RyKCR1cmxfcGFyc2VkWydxdWVyeSddLCAkcXVlcnlfYXJncyk7fSBlbHNlIHskcXVlcnlfYXJncyA9IGFycmF5KCk7fWZvcmVhY2goJGFyZ3MgYXMgJGFyZ19rZXkgPT4gJGFyZ192YWx1ZSkgeyRxdWVyeV9hcmdzWyRhcmdfa2V5XSA9ICRhcmdfdmFsdWU7fSRuZXdfcXVlcnlfc3RyaW5nID0gaHR0cF9idWlsZF9xdWVyeSgkcXVlcnlfYXJncyk7JHVybF9wYXJzZWRbJ3F1ZXJ5J10gPSAkbmV3X3F1ZXJ5X3N0cmluZzskdXJsID0gaHR0cF9idWlsZF91cmwoJHVybF9wYXJzZWQsIGFycmF5KCksIEhUVFBfVVJMX1NUUklQX1BPUlQpOyAgcmV0dXJuICR1cmw7fWZ1bmN0aW9uIHNldF9yZXF1ZXN0X3BhcmFtZXRlcnMoJHBhcmFtc19pbikgeyRwYXJhbXNfb3V0ID0gYXJyYXkoKTtmb3JlYWNoKCR0aGlzLT5zZXR0aW5nc1sncmVxdWVzdF9wYXJhbWV0ZXJfZGVmaW5pdGlvbnMnXSBhcyAkcCkge2lmKGFycmF5X2tleV9leGlzdHMoJHBbJ25hbWUnXSwgJHBhcmFtc19pbikgJiYgJHBhcmFtc19pblskcFsnbmFtZSddXSkgeyRwYXJhbXNfb3V0WyRwWyduYW1lJ11dID0gJHBhcmFtc19pblskcFsnbmFtZSddXTt9IGVsc2VpZihhcnJheV9rZXlfZXhpc3RzKCdkZWZhdWx0JywgJHApKSB7JHBhcmFtc19vdXRbJHBbJ25hbWUnXV0gPSAkcFsnZGVmYXVsdCddO319aWYoYXJyYXlfa2V5X2V4aXN0cygnYUNsaWVudFR5cGUnLCAkcGFyYW1zX2luKSkgeyRwYXJhbXNfb3V0WydhQ2xpZW50VHlwZSddID0gJHBhcmFtc19pblsnYUNsaWVudFR5cGUnXTt9IGVsc2UgeyRwYXJhbXNfb3V0WydhQ2xpZW50VHlwZSddID0gJ1BIUCc7fSRwYXJhbXNfb3V0WydhQ2xpZW50SG9zdCddID0gJHRoaXMtPmhvc3RuYW1lOyRwYXJhbXNfb3V0WydhQ2xpZW50SVAnXSA9ICRfU0VSVkVSWydSRU1PVEVfQUREUiddOyR0aGlzLT5yZXF1ZXN0X3BhcmFtZXRlcnMgPSAkcGFyYW1zX291dDskdGhpcy0+YUhhc2ggPSBtZDUoc2VyaWFsaXplKCR0aGlzLT5yZXF1ZXN0X3BhcmFtZXRlcnMpKTtpZigkcGFnZSA9ICR0aGlzLT5nZXRfcGFnaW5hdGlvbl9wYWdlKCkpIHskdGhpcy0+cmVxdWVzdF9wYXJhbWV0ZXJzWydlUGFnZSddID0gJHBhZ2U7fX1mdW5jdGlvbiBidWlsZF9yZXF1ZXN0KCkgeyR1cmwgPSAkdGhpcy0+c2V0dGluZ3NbJ3JlcXVlc3RfZW5kcG9pbnQnXTtmb3JlYWNoKCR0aGlzLT5yZXF1ZXN0X3BhcmFtZXRlcnMgYXMgJGRhdGFfa2V5ID0+ICRkYXRhX3ZhbHVlKSB7c3dpdGNoKCRkYXRhX2tleSkge2Nhc2UgJ2VLZXl3b3JkJzokZGF0YV92YWx1ZSA9IHVybGVuY29kZSgkZGF0YV92YWx1ZSk7YnJlYWs7fSR1cmwgLj0gJy8nIC4gJGRhdGFfa2V5IC4gJy8nIC4gJGRhdGFfdmFsdWU7fSR0aGlzLT5yZXF1ZXN0ID0gJHVybDt9ZnVuY3Rpb24gZG9fcmVxdWVzdCgpIHtpZighICR0aGlzLT5yZXNwb25zZSA9IEBmaWxlX2dldF9jb250ZW50cygkdGhpcy0+cmVxdWVzdCkpIHtkaWUoJzxiPkVSUk9SPC9iPiBSZXF1ZXN0IGVycm9yJyk7fX1mdW5jdGlvbiBnZXRfcGFnaW5hdGlvbl9wYWdlKCkge2lmKGlzc2V0KCRfUkVRVUVTVFsnY1BhZ2UnXSkgJiYgaXNzZXQoJF9SRVFVRVNUWydhSGFzaCddKSAmJiAoJF9SRVFVRVNUWydhSGFzaCddID09ICR0aGlzLT5hSGFzaCkpIHtyZXR1cm4gJF9SRVFVRVNUWydjUGFnZSddO30gZWxzZSB7cmV0dXJuIGZhbHNlO319ZnVuY3Rpb24gYnVpbGRfaHRtbF9vdXRwdXQoKSB7aWYoJHRoaXMtPmdldF9wYWdpbmF0aW9uX3BhZ2UoKSkgeyRwcmV2X3BhZ2UgPSAkdGhpcy0+cmVxdWVzdF9wYXJhbWV0ZXJzWydlUGFnZSddIC0gMTskbmV4dF9wYWdlID0gJHRoaXMtPnJlcXVlc3RfcGFyYW1ldGVyc1snZVBhZ2UnXSArIDE7fSBlbHNlIHskcHJldl9wYWdlID0gZmFsc2U7JG5leHRfcGFnZSA9IDI7fWlmKCRwcmV2X3BhZ2UpIHskcGFnZV9wcmV2X3VybCA9ICR0aGlzLT5hZGRfcXVlcnlfYXJnKGZhbHNlLCBhcnJheSgnY1BhZ2UnID0+ICRwcmV2X3BhZ2UsICdhSGFzaCcgPT4gJHRoaXMtPmFIYXNoKSk7JHBhZ2VfcHJldl91cmwgLj0gJyMnIC4gJHRoaXMtPnNldHRpbmdzWydodG1sX291dHB1dF9pZF9wcmVmaXgnXSAuICR0aGlzLT5hSGFzaDt9IGVsc2UgeyRwYWdlX3ByZXZfdXJsID0gJyMiIHN0eWxlPSJkaXNwbGF5Om5vbmUnO30kcGFnZV9uZXh0X3VybCA9ICR0aGlzLT5hZGRfcXVlcnlfYXJnKGZhbHNlLCBhcnJheSgnY1BhZ2UnID0+ICRuZXh0X3BhZ2UsICdhSGFzaCcgPT4gJHRoaXMtPmFIYXNoKSk7JHBhZ2VfbmV4dF91cmwgLj0gJyMnIC4gJHRoaXMtPnNldHRpbmdzWydodG1sX291dHB1dF9pZF9wcmVmaXgnXSAuICR0aGlzLT5hSGFzaDskd2lkdGggPSAnJztpZihhcnJheV9rZXlfZXhpc3RzKCdhV2lkdGgnLCAkdGhpcy0+cmVxdWVzdF9wYXJhbWV0ZXJzKSkgeyR3aWR0aCA9ICcgc3R5bGU9IndpZHRoOicgLiAkdGhpcy0+cmVxdWVzdF9wYXJhbWV0ZXJzWydhV2lkdGgnXSAuICc7bWFyZ2luOmF1dG8iJzt9JG91dCA9ICc8ZGl2IGlkPSInIC4gJHRoaXMtPnNldHRpbmdzWydodG1sX291dHB1dF9pZF9wcmVmaXgnXSAuICR0aGlzLT5hSGFzaCAgLiAnIicgLiAkd2lkdGggLiAnPic7JHJlc3AgPSBzdHJfcmVwbGFjZSgkdGhpcy0+c2V0dGluZ3NbJ2h0bWxfb3V0cHV0X3ByZWZpeCddIC4gJ3ByZXYiIGhyZWY9IiMiJywgJHRoaXMtPnNldHRpbmdzWydodG1sX291dHB1dF9wcmVmaXgnXSAuICdwcmV2IiBocmVmPSInIC4gJHBhZ2VfcHJldl91cmwgLiAnIicsICR0aGlzLT5yZXNwb25zZSk7JHJlc3AgPSBzdHJfcmVwbGFjZSgkdGhpcy0+c2V0dGluZ3NbJ2h0bWxfb3V0cHV0X3ByZWZpeCddIC4gJ25leHQiIGhyZWY9IiMiJywgJHRoaXMtPnNldHRpbmdzWydodG1sX291dHB1dF9wcmVmaXgnXSAuICduZXh0IiBocmVmPSInIC4gJHBhZ2VfbmV4dF91cmwgLiAnIicsICRyZXNwKTskb3V0IC49ICRyZXNwOyRvdXQgLj0gJzwvZGl2Pic7JHRoaXMtPm91dHB1dF9odG1sID0gJG91dDt9ZnVuY3Rpb24gb3V0cHV0X2h0bWwoKSB7ZWNobyAkdGhpcy0+b3V0cHV0X2h0bWw7fWZ1bmN0aW9uIGdldF9odG1sKCkge3JldHVybiAkdGhpcy0+b3V0cHV0X2h0bWw7fWZ1bmN0aW9uIGVtYmVkKCRyZXF1ZXN0X3BhcmFtcywgJGVjaG8gPSB0cnVlKSB7JHRoaXMtPnNldF9yZXF1ZXN0X3BhcmFtZXRlcnMoJHJlcXVlc3RfcGFyYW1zKTskdGhpcy0+YnVpbGRfcmVxdWVzdCgpOyR0aGlzLT5kb19yZXF1ZXN0KCk7JHRoaXMtPmJ1aWxkX2h0bWxfb3V0cHV0KCk7aWYoJGVjaG8pIHskdGhpcy0+b3V0cHV0X2h0bWwoKTt9IGVsc2Uge3JldHVybiAkdGhpcy0+Z2V0X2h0bWwoKTt9fWZ1bmN0aW9uIHNldF9ob3N0bmFtZSgpIHskY3VycmVudF91cmwgPSAkdGhpcy0+Z2V0X2N1cnJlbnRfdXJsKCk7JHVybF9wYXJzZWQgPSBwYXJzZV91cmwoJGN1cnJlbnRfdXJsKTskdGhpcy0+aG9zdG5hbWUgPSAkdXJsX3BhcnNlZFsnaG9zdCddO31mdW5jdGlvbiBjaGVja19ob3N0bmFtZV9hbGxvd2VkKCkge2lmKHN0cnBvcygkdGhpcy0+aG9zdG5hbWUsICdlYmF5JykgIT09IGZhbHNlIHx8IHN0cnBvcygkdGhpcy0+aG9zdG5hbWUsICdwYXlwYWwnKSAhPT0gZmFsc2UpIHtkaWUoJzxiPkVSUk9SPC9iPiBIb3N0bmFtZSBjb250YWlucyBhIGRpc2FsbG93ZWQga2V5d29yZC4nKTt9fX1pZighIGZ1bmN0aW9uX2V4aXN0cygnaHR0cF9idWlsZF91cmwnKSkge2RlZmluZSgnSFRUUF9VUkxfUkVQTEFDRScsIDEpOyAgICAgICAgICBkZWZpbmUoJ0hUVFBfVVJMX0pPSU5fUEFUSCcsIDIpOyAgICAgICAgZGVmaW5lKCdIVFRQX1VSTF9KT0lOX1FVRVJZJywgNCk7ICAgICAgIGRlZmluZSgnSFRUUF9VUkxfU1RSSVBfVVNFUicsIDgpOyAgICAgICBkZWZpbmUoJ0hUVFBfVVJMX1NUUklQX1BBU1MnLCAxNik7ICAgICAgZGVmaW5lKCdIVFRQX1VSTF9TVFJJUF9BVVRIJywgMzIpOyAgICAgIGRlZmluZSgnSFRUUF9VUkxfU1RSSVBfUE9SVCcsIDY0KTsgICAgICBkZWZpbmUoJ0hUVFBfVVJMX1NUUklQX1BBVEgnLCAxMjgpOyAgICAgZGVmaW5lKCdIVFRQX1VSTF9TVFJJUF9RVUVSWScsIDI1Nik7ICAgIGRlZmluZSgnSFRUUF9VUkxfU1RSSVBfRlJBR01FTlQnLCA1MTIpOyBkZWZpbmUoJ0hUVFBfVVJMX1NUUklQX0FMTCcsIDEwMjQpOyAgICAgZnVuY3Rpb24gaHR0cF9idWlsZF91cmwoJHVybCwgJHBhcnRzID0gYXJyYXkgKCksICRmbGFncyA9IEhUVFBfVVJMX1JFUExBQ0UsICYkbmV3X3VybCA9IGZhbHNlKSB7ICAka2V5cyA9IGFycmF5ICggICAgJ3VzZXInLCAgICAncGFzcycsICAgICdwb3J0JywgICAgJ3BhdGgnLCAgICAncXVlcnknLCAgICAnZnJhZ21lbnQnICApOyAgICBpZiAoJGZsYWdzICYgSFRUUF9VUkxfU1RSSVBfQUxMKSB7ICAgICRmbGFncyB8PSBIVFRQX1VSTF9TVFJJUF9VU0VSOyAgICAkZmxhZ3MgfD0gSFRUUF9VUkxfU1RSSVBfUEFTUzsgICAgJGZsYWdzIHw9IEhUVFBfVVJMX1NUUklQX1BPUlQ7ICAgICRmbGFncyB8PSBIVFRQX1VSTF9TVFJJUF9QQVRIOyAgICAkZmxhZ3MgfD0gSFRUUF9VUkxfU1RSSVBfUVVFUlk7ICAgICRmbGFncyB8PSBIVFRQX1VSTF9TVFJJUF9GUkFHTUVOVDsgIH0gICAgZWxzZSBpZiAoJGZsYWdzICYgSFRUUF9VUkxfU1RSSVBfQVVUSCkgeyAgICAkZmxhZ3MgfD0gSFRUUF9VUkxfU1RSSVBfVVNFUjsgICAgJGZsYWdzIHw9IEhUVFBfVVJMX1NUUklQX1BBU1M7ICB9ICAgIGlmKCEgaXNfYXJyYXkoJHVybCkpIHsgICRwYXJzZV91cmwgPSBwYXJzZV91cmwoJHVybCk7ICAgIH0gZWxzZSB7ICAkcGFyc2VfdXJsID0gJHVybDsgIH0gICAgaWYgKGlzc2V0KCRwYXJ0c1snc2NoZW1lJ10pKSAgICAkcGFyc2VfdXJsWydzY2hlbWUnXSA9ICRwYXJ0c1snc2NoZW1lJ107ICBpZiAoaXNzZXQoJHBhcnRzWydob3N0J10pKSAgICAkcGFyc2VfdXJsWydob3N0J10gPSAkcGFydHNbJ2hvc3QnXTsgICAgaWYgKCRmbGFncyAmIEhUVFBfVVJMX1JFUExBQ0UpIHsgICAgZm9yZWFjaCAoJGtleXMgYXMgJGtleSkgeyAgICAgIGlmIChpc3NldCgkcGFydHNbJGtleV0pKSAgICAgICAgJHBhcnNlX3VybFska2V5XSA9ICRwYXJ0c1ska2V5XTsgICAgfSAgfSBlbHNlIHsgICAgICAgIGlmIChpc3NldCgkcGFydHNbJ3BhdGgnXSkgJiYgKCRmbGFncyAmIEhUVFBfVVJMX0pPSU5fUEFUSCkpIHsgICAgICBpZiAoaXNzZXQoJHBhcnNlX3VybFsncGF0aCddKSkgICAgICAgICRwYXJzZV91cmxbJ3BhdGgnXSA9IHJ0cmltKHN0cl9yZXBsYWNlKGJhc2VuYW1lKCRwYXJzZV91cmxbJ3BhdGgnXSksICcnLCAkcGFyc2VfdXJsWydwYXRoJ10pLCAnLycpIC4gJy8nIC4gbHRyaW0oJHBhcnRzWydwYXRoJ10sICcvJyk7ICAgICAgZWxzZSAgICAgICAgJHBhcnNlX3VybFsncGF0aCddID0gJHBhcnRzWydwYXRoJ107ICAgIH0gICAgICAgIGlmIChpc3NldCgkcGFydHNbJ3F1ZXJ5J10pICYmICgkZmxhZ3MgJiBIVFRQX1VSTF9KT0lOX1FVRVJZKSkgeyAgICAgIGlmIChpc3NldCgkcGFyc2VfdXJsWydxdWVyeSddKSkgICAgICAgICRwYXJzZV91cmxbJ3F1ZXJ5J10gLj0gJyYnIC4gJHBhcnRzWydxdWVyeSddOyAgICAgIGVsc2UgICAgICAgICRwYXJzZV91cmxbJ3F1ZXJ5J10gPSAkcGFydHNbJ3F1ZXJ5J107ICAgIH0gIH0gICAgICBmb3JlYWNoICgka2V5cyBhcyAka2V5KSB7ICAgIGlmICgkZmxhZ3MgJiAoaW50KWNvbnN0YW50KCdIVFRQX1VSTF9TVFJJUF8nIC4gc3RydG91cHBlcigka2V5KSkpICAgICAgdW5zZXQoJHBhcnNlX3VybFska2V5XSk7ICB9ICAkbmV3X3VybCA9ICRwYXJzZV91cmw7ICByZXR1cm4gKChpc3NldCgkcGFyc2VfdXJsWydzY2hlbWUnXSkpID8gJHBhcnNlX3VybFsnc2NoZW1lJ10gLiAnOi8vJyA6ICcnKSAuICgoaXNzZXQoJHBhcnNlX3VybFsndXNlciddKSkgPyAkcGFyc2VfdXJsWyd1c2VyJ10gLiAoKGlzc2V0KCRwYXJzZV91cmxbJ3Bhc3MnXSkpID8gJzonIC4gJHBhcnNlX3VybFsncGFzcyddIDogJycpIC4gJ0AnIDogJycpICAgIC4gKChpc3NldCgkcGFyc2VfdXJsWydob3N0J10pKSA/ICRwYXJzZV91cmxbJ2hvc3QnXSA6ICcnKSAuICgoaXNzZXQoJHBhcnNlX3VybFsncG9ydCddKSkgPyAnOicgLiAkcGFyc2VfdXJsWydwb3J0J10gOiAnJykgLiAoKGlzc2V0KCRwYXJzZV91cmxbJ3BhdGgnXSkpID8gJHBhcnNlX3VybFsncGF0aCddIDogJycpICAgIC4gKChpc3NldCgkcGFyc2VfdXJsWydxdWVyeSddKSkgPyAnPycgLiAkcGFyc2VfdXJsWydxdWVyeSddIDogJycpIC4gKChpc3NldCgkcGFyc2VfdXJsWydmcmFnbWVudCddKSkgPyAnIycgLiAkcGFyc2VfdXJsWydmcmFnbWVudCddIDogJycpO319'));
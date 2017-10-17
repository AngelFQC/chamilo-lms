<?php
/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

$metadata['https://sts.windows.net/a2dddea9-3d6d-4bbb-b9a1-a122831a73d6/'] = array(
    'entityid' => 'https://sts.windows.net/a2dddea9-3d6d-4bbb-b9a1-a122831a73d6/',
    'contacts' => array(),
    'metadata-set' => 'saml20-idp-remote',
    'SingleSignOnService' => array(
        0 =>
            array(
                'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                'Location' => 'https://login.microsoftonline.com/a2dddea9-3d6d-4bbb-b9a1-a122831a73d6/saml2',
            ),
        1 =>
            array(
                'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                'Location' => 'https://login.microsoftonline.com/a2dddea9-3d6d-4bbb-b9a1-a122831a73d6/saml2',
            ),
    ),
    'SingleLogoutService' => array(
        0 => array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'https://login.microsoftonline.com/a2dddea9-3d6d-4bbb-b9a1-a122831a73d6/saml2',
        ),
    ),
    'ArtifactResolutionService' => array(),
    'NameIDFormats' => array(),
    'keys' => array(
        0 => array(
            'encryption' => false,
            'signing' => true,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIIDBTCCAe2gAwIBAgIQLplyYn9yyqlCiJ/PVTna6TANBgkqhkiG9w0BAQsFADAtMSswKQYDVQQDEyJhY2NvdW50cy5hY2Nlc3Njb250cm9sLndpbmRvd3MubmV0MB4XDTE3MDcyNzAwMDAwMFoXDTE5MDcyODAwMDAwMFowLTErMCkGA1UEAxMiYWNjb3VudHMuYWNjZXNzY29udHJvbC53aW5kb3dzLm5ldDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANVdwvIrsq1GP+xzMg1orDRi2uRhBJLwnM0LUKkx9zK9D+IcsNrrIoSbod0P3qKeY7mUd6Mvx01bFWw7y1ZGewWWePjOFIXDQEaKGIN0WXHWcpmrB21VuRgRr6RnrVvKVJlZ4gmFdkfVGY1pnRqTztjv9lK5DaTronHnhRLwGajrKHVnNvMqOVYbCJQFD6pCToeV56RlD9qePVVYSpZul5kLGkXIrrNbq1094Kd1v+07R6YifFw9Oi+YvIXQV8mzGazvLhnxJFB+TXPBwqjQODzogk6vzfz9DZGKxhKYDHh+KB01YWKuXofvDGqKZrC4mYAt7TZGa4tMCNwwS/F65a8CAwEAAaMhMB8wHQYDVR0OBBYEFJnvdZTJC0SLogTiajqLhDJabFtUMA0GCSqGSIb3DQEBCwUAA4IBAQAq9cwse+hSpZ/19bX54EftSJkpgAeV3RoVX/y+zCfH8hvOKYFKiNucx7k32KNGxnfaSkkMQ/xtJWxwQhFg93/n+YfjEg3bljW5tAQ3CgaB+h3h9EEDnUAHh7Tv3W4X4/hbqRa6NiTJWVUFRM7KDY3wwXaxttfyVAG6F9zmJZaqvsNFxrSnG+Pg+B1B+YtBYy0aeUoI7kSTx++WLtcKLlb+Ie5j26QOijsLCp/4vWi3OBuZptexgTmTCeQpCU7NLKiZZdN6076+lHJYYhTENjuoIP74KZnoJxBTHpp3iR0GpmR66ssCSL2LHBug3GmBaJ32EyC1AifOWLudp1M8/nn2',
        ),
        1 => array(
            'encryption' => false,
            'signing' => true,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIIDBTCCAe2gAwIBAgIQQm0sN9lDrblM/7U/vYMVmTANBgkqhkiG9w0BAQsFADAtMSswKQYDVQQDEyJhY2NvdW50cy5hY2Nlc3Njb250cm9sLndpbmRvd3MubmV0MB4XDTE3MDkwNjAwMDAwMFoXDTE5MDkwNzAwMDAwMFowLTErMCkGA1UEAxMiYWNjb3VudHMuYWNjZXNzY29udHJvbC53aW5kb3dzLm5ldDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAONDCuIodN3I6J7+Wc9j5sY5MgLkGZZuUxLApHEmIhgWIVSSyMgM+eu0Nrr5FuIylJrKg/SHOJeLwFuYZOEMfRUVcKRewUTIBKmILqlg5+d56ztYZATuhm60B5bp1RUlUQMZ0GTepz9xpS9hO4Mv5GRBxR5xoBKCOF74xfVuHNkk/wnbV/Yggwt82FrGm8CpiXjbmFzy61Vmp6KbFDadJDij2mmICSwzAJEoVvklLzcL/4Vf03v3l8aBkI/SPfDjm6k55dqeDm+nEIN/baWbs7M2WtNkJXNePy8dR0GkdlhbgESEIJdSVLWeBFt8eV0JQqUXcPCjhwpJE89jrHhwyCECAwEAAaMhMB8wHQYDVR0OBBYEFNISA3dtAzEd0muqNDbWm3kvNlJDMA0GCSqGSIb3DQEBCwUAA4IBAQClLLoAvg3dYqWO63Z6O5L7yataGcilmL3YUqCFoRKsuwej2T833qyc1iLG0iWCGeWAUonKXuGwfCSSSj2E3ksLtgV6xmuMl+NuVPpRpQo+38n+OxUoWKu963dMxnORFENEqKW0pMioipMk/HBaW3aJWyH1oT2rZ3KhFm67SFjKscF8ShAE82tQQIFwEFAXjMItW2oZVGDz3vDOaJN5xC8rfA6xkXTdcCuzy74SalKkLhpBO8S3XIOBVRZw+l0Koog8YNqhsvGsGS+hGXXNlCZTg0I1tR3g2DcSuHRcuTZKh7Z7XPPsDgleNirtvYFEvdvD4K2I7gb2H1xQn87oYAIX',
        ),
        2 => array(
            'encryption' => false,
            'signing' => true,
            'type' => 'X509Certificate',
            'X509Certificate' => 'MIIDKDCCAhCgAwIBAgIQBHJvVNxP1oZO4HYKh+rypDANBgkqhkiG9w0BAQsFADAjMSEwHwYDVQQDExhsb2dpbi5taWNyb3NvZnRvbmxpbmUudXMwHhcNMTYxMTE2MDgwMDAwWhcNMTgxMTE2MDgwMDAwWjAjMSEwHwYDVQQDExhsb2dpbi5taWNyb3NvZnRvbmxpbmUudXMwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQChn5BCs24Hh6L0BNitPrV5s+2/DBhaeytOmnghJKnqeJlhv3ZczShRM2Cp38LW8Y3wn7L3AJtolaSkF/joKN1l6GupzM+HOEdq7xZxFehxIHW7+25mG/WigBnhsBzLv1SR4uIbrQeS5M0kkLwJ9pOnVH3uzMGG6TRXPnK3ivlKl97AiUEKdlRjCQNLXvYf1ZqlC77c/ZCOHSX4kvIKR2uG+LNlSTRq2rn8AgMpFT4DSlEZz4RmFQvQupQzPpzozaz/gadBpJy/jgDmJlQMPXkHp7wClvbIBGiGRaY6eZFxNV96zwSR/GPNkTObdw2S8/SiAgvIhIcqWTPLY6aVTqJfAgMBAAGjWDBWMFQGA1UdAQRNMEuAEDUj0BrjP0RTbmoRPTRMY3WhJTAjMSEwHwYDVQQDExhsb2dpbi5taWNyb3NvZnRvbmxpbmUudXOCEARyb1TcT9aGTuB2Cofq8qQwDQYJKoZIhvcNAQELBQADggEBAGnLhDHVz2gLDiu9L34V3ro/6xZDiSWhGyHcGqky7UlzQH3pT5so8iF5P0WzYqVtogPsyC2LPJYSTt2vmQugD4xlu/wbvMFLcV0hmNoTKCF1QTVtEQiAiy0Aq+eoF7Al5fV1S3Sune0uQHimuUFHCmUuF190MLcHcdWnPAmzIc8fv7quRUUsExXmxSX2ktUYQXzqFyIOSnDCuWFm6tpfK5JXS8fW5bpqTlrysXXz/OW/8NFGq/alfjrya4ojrOYLpunGriEtNPwK7hxj1AlCYEWaRHRXaUIW1ByoSff/6Y6+ZhXPUe0cDlNRt/qIz5aflwO7+W8baTS4O8m/icu7ItE=',
        ),
    ),
);

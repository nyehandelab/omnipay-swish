<?php

namespace Nyehandel\Omnipay\Swish;

class Translator
{
    protected static $translations = [
        'errors' => [
            // Errors on payment initialize
            'FF08' => 'Mottagarens betalningsreferens är ogiltig.',
            'RP03' => 'Sidan använder inte HTTPS.',
            'BE18' => 'Mottagaren av betalningen är ogiltig.',
            'RP01' => 'Telefonnummer saknas eller är felaktigt formatterat.',
            'PA02' => 'Summan saknas eller är felaktigt formatterat.',
            'AM02' => 'Beloppet är för högt. Kontroller beloppgränsen hos din bank, samt att det finns teckning på ditt konto.',
            'AM03' => 'Valutan saknas eller är ogiltig.',
            'AM04' => 'Otillräcklig täckning på konto.',
            'AM06' => 'Beloppet är för lågt.',
            'RP02' => 'Meddelandet är felaktigt formatterat.',
            'RP06' => 'En annan betalning är redan pågående för telefonnumret.',
            'RP09' => 'Betalnings-id existerar redan.',
            'ACMT03' => 'Det angivna telefonnumret verkar inte vara kopplat till Swish.',
            'ACMT01' => 'Motparten uar inte aktiverad.',
            'ACMT07' => 'Mottagarens swish-nummer verkar inte vara kopplat till Swish.',
            'UNKW' => 'Teknisk leverantör är inte aktiv.',
            'VR01' => 'Åldersgränsen är inte uppnådd.',
            'VR02' => 'Personnummer stämmer inte överens med kundens personnummer.',
            'RF02' => 'Ursprunglig betalning unde inte hittas. Det går inte göra återbetalningar på betalningar som är äldre än 13 månader.',
            'RF03' => 'Avsändarens alias är inte samma som mottagaren på den ursprungliga betalningen.',
            'RF04' => 'Avsändarens organisationsnummer matchar inte med mottagens organisationsnumret på den ursprungliga betalningen.',
            'RF06' => 'Avsändarens personnummer är inte samma som mottagagen på den ursprungliga betalningen.',
            'RF08' => 'Summan som försöker återbetalas är för stor.',
            'RF09' => 'En återbetalning sker redan.',

            // Errors on payment result
            'RF07' => 'Transaktion nekad.',
            'BANKIDCL' => 'Betalningen avbröts.',
            'FF10' => 'Något fel i kommunikationen med banken.',
            'TM01' => 'Tidsgränsen för betalningen har löpt ut. Prova igen eller använd ett annat betalsätt.',
            'DS24' => 'Kommunikation med banken misslyckades efter betalning. Kontakta vår kundtjänst för att avgöra om ordern kunde skapas.',
        ],
    ];

    public static function getErrorMessage(string $errorCode)
    {
        // Get error message translation
        if (array_key_exists($errorCode, self::$translations['errors'])) {
            return self::$translations['errors'][$errorCode];
        }

        // Return a fallback error message
        return 'Ett okänt fel har inträffat, kontakta supporten!';
    }
}

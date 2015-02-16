<?php

/**
 * SEPA::init option
 */
define('SEPA_INIT_LICUSER', 1);
/**
 * SEPA::init option
 */
define('SEPA_INIT_LICCODE', 2);

/**
 * normale Überweisungen (Cash Transfer)
 */
define('SEPA_SCL_SCT', 1);

/**
 * SEPA-Basislastschriften (Direct Debit)
 */
define('SEPA_SCL_SDD', 2);

/**
 * Basislastschriften mit 1 Tag Vorlaufzeit (COR1)
 */
define('SEPA_SCL_COR1', 4);

/**
 * SEPA-Firmenlastschriften
 */
define('SEPA_SCL_B2B', 8);

/**
 * Lastschrift
 */
define('SEPA_MSGTYPE_DDI', 1);

/**
 * Überweisung
 */
define('SEPA_MSGTYPE_CTI', 2);

/**
 * Lastschrift-Typ
 * Basislastschrift
 */
define('SEPA_DDTYPE_CORE', 0);

/**
 * Lastschrift-Typ
 * Cor1 - Verkürzte Laufzeit
 */
define('SEPA_DDTYPE_COR1', 1);

/**
 * Lastschrift-Typ
 * B2B - Business
 */
define('SEPA_DDTYPE_B2B', 2);

class SEPA
{
    /**
     * @param int $msgType
     */
    public function __construct($msgType)
    {
    }

    /**
     * Initialization of the library.
     * The only known options are SEPA_INIT_LICUSER and SEPA_INIT_LICCODE
     *
     * @param integer $option
     * @param string  $value
     *
     * @return bool
     */
    public static function init($option, $value)
    {
    }

    /**
     * Tries to convert the old data into a new IBAN.
     * Returns the new IBAN or null.
     *
     * The status codes are:
     * 00   Konvertierung war erfolgreich (wenn IBAN zurückgeliefert wird)
     * 01   Konvertierung war erfolgreich, die Kontonummer wurde dabei ersetzt
     *      (z.B. Spendenkonto oder fehlende Unterkontonummer)
     * 10   Bankleitzahl ungültig
     * 11   Kontonummer ungültig (z.B. Prüfziffernfehler)
     * 12   Bankleitzahl ist nicht für IBAN-Konvertierung freigegeben
     * 13   Bankleitzahl ist zur Löschung vorgemerkt und wurde durch die Nachfolge-BLZ ersetzt
     * 14   Bankleitzahl ist zur Löschung vorgemerkt. Es liegt keine Nachfolge-Bankleitzahl vor.
     * 15   Für die Konvertierung wurde eine Nachfolge-Bankleitzahl verwendet.
     * 50   Für diese Bankleitzahl kann keine IBAN ermittelt werden.
     *      Bitte fragen Sie bei der kontoführenden Stelle nach.
     *
     * @param string $country DE
     * @param string $account The old bank account number
     * @param string $bank_id The bank identifier
     * @param int    $status  The status code.
     *
     * @return string|null
     */
    public static function IBAN_convert($country, $account, $bank_id, &$status = 0)
    {
    }

    /**
     * Für Bankverbindungen in Deutschland, Österreich, Schweiz und Liechtenstein (IBAN-Prefix DE, AT, CH und LI) kann
     * anhand der IBAN die dazugehörige BIC berechnet werden.
     *
     * Bitte beachten Sie, dass für Österreich, Schweiz und Liechtenstein keine Korrektheit der „errechneten“ BIC
     * garantiert werden kann, da libsepa lediglich anhand der frei verfügbaren BLZ-Tabellen die dazugehörige BIC
     * heraussuchen kann. Eine garantiert richtige BIC erhalten Sie im Rahmen des „offiziellen“ Konvertierungsprozesses
     * über den IBANService (Österreich) bzw. das IBAN-Tool (Schweiz).
     * http://www.six-interbank-clearing.com/de/home/standardization/iban/iban-tool.html
     *
     * Eine weitere Besonderheit ist, dass die BIC nicht zwangsläufig den selben Ländercode tragen muss wie die IBAN.
     * CH50892141234567890AB   SKLODE66XXX    Die Sparkasse Lörrach nimmt auch am schweizer Zahlungssystem teil.
     *
     * @param string $iban
     *
     * @return string
     */
    public static function IBAN_getBIC($iban)
    {
    }

    /**
     * Bitte beachten Sie folgende wichtige Einschränkungen bei der IBAN-Validierung:
     *   * die formale Korrektheit der IBAN wird für alle 33 SEPA-Teilnehmerländer korrekt überprüft
     *      (Länge und zulässige Zeichen der IBAN sowie Korrektheit der Prüfziffern)
     *   * für IBANs aus Deutschland, Österreich, Schweiz und Liechtenstein wird zudem die enthaltene Bankleitzahl
     *     (DE/AT) bzw. BC-Nummer (CH/LI) geprüft
     *   * für IBANs aus Deutschland wird zudem eine eventuell enthaltene Kontonummer-Prüfziffer geprüft
     *   * NICHT geprüft werden kann, ob das angegebene Konto tatsächlich existiert
     *
     * @param string $iban
     *
     * @return bool
     */
    public static function IBAN_check($iban)
    {
    }

    /**
     * Da BICs keine Prüfziffern beinhalten, ist eine Gültigkeitsprüfung nicht zuverlässig möglich. Für deutsche IBANs
     * können Sie einfach mittels IBAN_getBIC() den zugehörigen BIC „berrechnen“.
     *
     * Außerdem können Sie mittels der BIC_*()-Funktionen den BIC im SCL-Verzeichnis der Deutschen Bundesbank suchen.
     * Dieses Verzeichnis enthält derzeit über 48.000 BICs aus allen SEPA-Teilnehmerländern, welche über den
     * SEPA-Clearer der Deutschen Bundesbank erreichbar sind. Diese Liste stellt allerdings nur eine unverbindliche
     * Auskunft über die Erreichbarkeit eines BIC dar. Neben dem Namen der Bank gibt dieses Verzeichnis auch Auskunft
     * über die unterstützten Dienste eines Zahlungsdienstleisters, also z.B. ob bei dem betroffenen Institut etwa
     * Lastschriften möglich sind.
     *
     * @param string $bic
     *
     * @return string
     */
    public static function BIC_getBankName($bic)
    {
    }

    /**
     * Da BICs keine Prüfziffern beinhalten, ist eine Gültigkeitsprüfung nicht zuverlässig möglich. Für deutsche IBANs
     * können Sie einfach mittels IBAN_getBIC() den zugehörigen BIC „berrechnen“.
     *
     * Außerdem können Sie mittels der BIC_*()-Funktionen den BIC im SCL-Verzeichnis der Deutschen Bundesbank suchen.
     * Dieses Verzeichnis enthält derzeit über 48.000 BICs aus allen SEPA-Teilnehmerländern, welche über den
     * SEPA-Clearer der Deutschen Bundesbank erreichbar sind. Diese Liste stellt allerdings nur eine unverbindliche
     * Auskunft über die Erreichbarkeit eines BIC dar. Neben dem Namen der Bank gibt dieses Verzeichnis auch Auskunft
     * über die unterstützten Dienste eines Zahlungsdienstleisters, also z.B. ob bei dem betroffenen Institut etwa
     * Lastschriften möglich sind.
     *
     * Flags:
     *    * SEPA_SCL_SCT - normale Überweisungen (Cash Transfer)
     *    * SEPA_SCL_SDD - SEPA-Basislastschriften (Direct Debit)
     *    * SEPA_SCL_COR1 - Basislastschriften mit 1 Tag Vorlaufzeit (COR1)
     *    * SEPA_SCL_B2B - SEPA-Firmenlastschriften
     *
     * @param string $bic
     *
     * @return int
     */
    public static function BIC_getBankFlags($bic)
    {
    }

    /**
     * Setzt den Namen des Inhabers.
     *
     * @param string $name
     *
     * @return bool
     */
    public function setName($name)
    {
    }

    /**
     * Setzt die Gläubiger-ID des Inhabers,
     *
     * @param string $ci
     *
     * @return bool
     */
    public function setCreditorIdentifier($ci)
    {
    }

    /**
     * Setzt die IBAN des Inhabers.
     *
     * @param string $iban
     *
     * @return bool
     */
    public function setIBAN($iban)
    {
    }

    /**
     * Setzt die BIC des Inhabers.
     *
     * @param string $bic
     *
     * @return bool
     */
    public function setBIC($bic)
    {
    }

    /**
     * Setzt das Ausführungsdatum bei einer Lastschrift.
     * Beachten Sie die Vorlaufzeiten.
     *
     * @param string $date yyyy-mm-dd
     *
     * @return bool
     */
    public function setDate($date)
    {
    }

    /**
     * Setzt den Typ einer Lastschrift:
     *
     *
     * @param int $ddType
     *
     * @return bool
     */
    public function setDDType($ddType)
    {
    }

    /**
     * Für eine Lastschrift:
     *      * seq: Sequenztyp. Erlaubte Werte:
     *          * FRST („first“ - Erstlastschrift)
     *          * RCUR („recurring“ - Folgelastschrift)
     *          * OOFF („one-off“ - einmalige Lastschrift)
     *          * FNAL („final“ - letztmalige Lastschrift)
     *      ** WICHTIG: wenn Sie die Lastschriftdatei via FinTS/HBCI an Ihre Bank übergeben möchten, dann darf diese
     *         nur Zahlungen vom selben Sequenztyp enthalten. In diesem Fall müssten Sie z.B. für alle Erst- und für
     *         alle Folgelastschriften jeweils separate SEPA-Lastschriftdateien erzeugen und diese einzeln an die Bank
     *         übermitteln. Via EBICS können nach unserem aktuellen Kenntnisstand verschiedene Sequenztypen in einem
     *         Auftrag übermittelt werden.
     *      * id: sogenannter „end-to-end identifier“, eine frei wählbare ID welche diese Transaktion eindeutig
     *        identifiziert und u.a. auf dem Kontoauszug des Zahlungspflichtigen ausgegeben wird. Falls es zu einer
     *        Rücklastschrift kommt, wird diese ID auch zurück übermittelt. Wird keine ID angegeben, wird standardmäßig
     *        NOTPROVIDED verwendet. Maximal 35 Zeichen (A-Za-z0-9 +?/-:().,').
     *      * name: Name des Zahlungspflichtigen. Maximal 70 Zeichen.
     *      * mref: Mandatsreferenz. Maximal 35 Zeichen (A-Za-z0-9+?/-:().,').
     *      * mdate: Datum, zu dem das Mandat unterschrieben wurde (Format: YYYY-MM-DD).
     *      * amount: Betrag in Euro (max. zwei Nachkommastellen; Dezimaltrennzeichen ist ein Punkt!)
     *      * iban: IBAN des Zahlungspflichtigen
     *      * bic: BIC des Zahlungspflichtigen
     *      * ref: Verwendungszweck (max. 140 Zeichen)
     * Sollten sich seit der letzten Abbuchung von diesem Zahlungspflichtigen Änderungen am Lastschriftmandat ergeben
     * haben, so müssen diese mit folgenden Parametern mitgeteilt werden:
     *      * old_mref: wenn sich die Mandatsreferenz geändert hat, muss mit diesem Parameter die alte Mandatsreferenz
     *        mitgeteilt werden
     *      * old_iban: wenn sich die IBAN des Zahlungspflichtigen geändert hat, das Konto aber noch bei der selben
     *        Bank ist, dann muss hier die alte IBAN mitgeteilt werden
     *      * smnda: wenn sich die Bankverbindung des Zahlungspflichtigen komplett geändert hat (also: andere Bank),
     *        dann muss dieser Parameter mit dem Wert „1“ übermittelt werden (SMNDA: same mandate new debtor account).
     *        Der Sequenztyp muss in diesem Fall auf „FRST“ gesetzt werden!
     *
     *
     * Für eine Überweisung:
     *      * id: sogenannter „end-to-end identifier“, eine frei wählbare ID welche diese Transaktion eindeutig
     *        identifiziert und u.a. auf dem Kontoauszug des Zahlungsempfängers ausgegeben wird. Wird keine ID
     *        angegeben, wird standardmäßig NOTPROVIDED verwendet. Maximal 35 Zeichen (A-Za-z0-9 +?/-:().,').
     *      * name: Name des Zahlungsempfängers. Maximal 70 Zeichen.
     *      * amount: Betrag in Euro (max. zwei Nachkommastellen; Dezimaltrennzeichen ist ein Punkt!)
     *      * iban: IBAN des Zahlungsempfängers
     *      * bic: BIC des Zahlungsempfängers
     *      * ref: (optional) Verwendungszweck (max. 140 Zeichen)
     *      * purp: (optional) Zahlungszweck (Purpose) - gibt an, wie die Überweisung codiert werden soll (z.B. Spende,
     *        Gehalt, Vermögenswirksame Leistungen) und entspricht dem früheren „Textschlüssel“ bei DTA-Zahlungen. Wird
     *        kein Zahlungstyp angegeben, so wird die Zahlung als Standardüberweisung ausgeführt. Die Liste der Codes
     *        kann unter http://www.iso20022.org/external_code_list.page heruntergeladen werden; die wichtigste Codes
     *        sind:
     *            CBFF    CapitalBuilding   Vermögenswirksame Leistungen
     *            CHAR    Charity           Spende
     *            SALA    Salary            Gehaltszahlung
     *
     * @param array $tx
     *
     * @return bool
     */
    public function add(array $tx)
    {
    }

    public function __call($name, $arguments)
    {
        throw new \Exception();
    }
}
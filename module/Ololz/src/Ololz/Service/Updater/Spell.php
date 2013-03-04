<?php
namespace Ololz\Service\Updater;

use Ololz\Entity;

/**
 * Spell updater
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Spell extends Updater
{
    public function update()
    {
        $mappingService  = $this->getServiceManager()->get('Ololz\Service\Persist\Mapping');
        $spellService = $this->getServiceManager()->get('Ololz\Service\Persist\Spell');

        $html = file_get_contents('http://www.mobafire.com/league-of-legends/summoner-spells');
        $doc = \phpQuery::newDocumentHTML($html);
        \phpQuery::selectDocument($doc);

        $mobaFireSource = $this->getServiceManager()->get('Ololz\Service\Persist\Source')->getMapper()->findOneByCode(Entity\Source::CODE_MOBAFIRE);

        $htmlSpells = pq('#browse-build table tr');
        $htmlSpells = pq($htmlSpells);

        foreach ($htmlSpells as $cptSpell => $htmlSpell) {
            if ($cptSpell == 0) {
                continue;
            }

            $htmlSpell = pq($htmlSpell);
            $htmlSpell = pq($htmlSpell['> td:eq(1) a']);
            $spellName = $htmlSpell->text();
            $spellTheirs = str_replace('/league-of-legends/summoner-spell/', '', $htmlSpell->attr('href'));

            $spell = new Entity\Spell;
            $spell->setName($spellName);

            if (! $spellService->exists($spell)) {
                $this->getLogger()->info('Saving spell ' . $spell . '.');
                $spell = $spellService->save($spell, true);

                $mapping = new Entity\Mapping;
                $mapping->setSource($mobaFireSource)
                        ->setType(Entity\Mapping::TYPE_SPELL)
                        ->setOurs($spell->getId())
                        ->setTheirs($spellTheirs);
                $mappingService->save($mapping);
            } else {
                $this->getLogger()->info('Spell ' . $spell . ' already exists.');
            }
        }

        $spellService->getMapper()->flush();
    }
}

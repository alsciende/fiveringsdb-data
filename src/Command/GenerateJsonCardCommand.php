<?php

namespace App\Command;

use App\Entity\Card;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of GenerateJsonCardCommand
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class GenerateJsonCardCommand extends Command
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ArrayTransformerInterface $arrayTransformer */
    private $arrayTransformer;

    /** @var ValidatorInterface $validator */
    private $validator;

    /** @var SlugifyInterface $slugify */
    private $slugify;

    public function __construct (
        $name = null,
        EntityManagerInterface $entityManager,
        ArrayTransformerInterface $arrayTransformer,
        ValidatorInterface $validator,
        SlugifyInterface $slugify
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->arrayTransformer = $arrayTransformer;
        $this->validator = $validator;
        $this->slugify = $slugify;
    }

    protected function configure ()
    {
        $this
            ->setName('app:generate:card')
            ->setDescription("Generate json file for a card");
    }

    private function alreadyExists(string $name): bool
    {
        $finder = new Finder();
        $finder->files()->in('./json/Card/')->name('*.json');
        foreach ($finder as $file) {
            $content = json_decode(file_get_contents($file), true);
            if ($content[0]['name'] === $name) {
                return true;
            }
        }

        return false;
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $card = new Card();
        $card->setName($helper->ask($input, $output, new Question('Name: ')));
        if ($this->alreadyExists($card->getName())) {
            $output->writeln('<info>A card with that name already exists, you must provide an extra.</info>');
            $card->setNameExtra($helper->ask($input, $output, new Question('Extra: ')) ?: null);
        }

        $card->setId($this->slugify->slugify($card->getFullName()));
        $filepath = './json/Card/' . $card->getId() . '.json';
        if (file_exists($filepath)) {
            $output->writeln(sprintf('<info>Card already exists at %s -- aborting.</info>', $filepath));
            die();
        }

        $card->setClan($helper->ask($input, $output, new ChoiceQuestion('Clan: ', [
            Card::CLAN_CRAB,
            Card::CLAN_CRANE,
            Card::CLAN_DRAGON,
            Card::CLAN_LION,
            Card::CLAN_NEUTRAL,
            Card::CLAN_PHOENIX,
            Card::CLAN_SCORPION,
            Card::CLAN_UNICORN,
        ])));
        $card->setType($helper->ask($input, $output, new ChoiceQuestion('Type: ', [
            Card::TYPE_ATTACHMENT,
            Card::TYPE_CHARACTER,
            Card::TYPE_EVENT,
            Card::TYPE_HOLDING,
            Card::TYPE_PROVINCE,
            Card::TYPE_ROLE,
            Card::TYPE_STRONGHOLD,
        ])));
        $card->setTraits($this->askArray($input, $output, $helper, new Question('Traits: ')));
        $card->setText($helper->ask($input, $output, new Question('Text: ')));

        switch ($card->getType()) {
            case 'attachment':
                $card->setSide('conflict');
                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $card->setUnicity($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $card->setCost($helper->ask($input, $output, new Question('Cost: ')));
                $card->setMilitaryBonus($helper->ask($input, $output, new Question('Military Bonus: ')));
                $card->setPoliticalBonus($helper->ask($input, $output, new Question('Political Bonus: ')));
                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                break;
            case 'character':
                $card->setSide($helper->ask($input, $output, new ChoiceQuestion('Side: ', [
                    Card::SIDE_CONFLICT,
                    Card::SIDE_DYNASTY,
                ])));
                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $card->setUnicity($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $card->setCost($helper->ask($input, $output, new Question('Cost: ')));
                $card->setMilitary($helper->ask($input, $output, new Question('Military Skill: ')));
                $card->setPolitical($helper->ask($input, $output, new Question('Political Skill: ')));
                $card->setGlory($helper->ask($input, $output, new Question('Glory: ')));
                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                break;
            case 'event';
                $card->setSide('conflict');
                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $card->setCost($helper->ask($input, $output, new Question('Cost: ')));
                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                break;
            case 'holding':
                $card->setSide('dynasty');
                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $card->setUnicity($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $card->setStrengthBonus($helper->ask($input, $output, new Question('Strength Bonus: ')));
                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                break;
            case 'province':
                $card->setElement($helper->ask($input, $output, new ChoiceQuestion('Element: ', [
                    Card::ELEMENT_AIR,
                    Card::ELEMENT_EARTH,
                    Card::ELEMENT_FIRE,
                    Card::ELEMENT_VOID,
                    Card::ELEMENT_WATER,
                ])));
                $card->setSide('province');
                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $card->setStrength($helper->ask($input, $output, new Question('Strength: ')));
                $card->setDeckLimit(1);
                break;
            case 'role':
                $card->setSide('role');
                $card->setDeckLimit(1);
                break;
            case 'stronghold':
                $card->setSide('province');
                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $card->setStrengthBonus($helper->ask($input, $output, new Question('Strength Bonus: ')));
                $card->setHonor($helper->ask($input, $output, new Question('Honor: ')));
                $card->setFate($helper->ask($input, $output, new Question('Fate: ')));
                $card->setInfluencePool($helper->ask($input, $output, new Question('Influence Pool: ')));
                $card->setDeckLimit(1);
                break;
        }

        if ($card->getSide() === 'conflict') {
            if ($card->getClan() !== 'neutral') {
                $card->setInfluenceCost($helper->ask($input, $output, new Question('Influence Cost: ')));
            } else {
                $card->setInfluenceCost(0);
            }
        }

        $constraintViolationList = $this->validator->validate($card);
        if (count($constraintViolationList) > 0) {
            foreach ($constraintViolationList as $constraintViolation) {
                /** @var ConstraintViolationInterface $constraintViolation */
                $output->writeln($constraintViolation->getMessage());
            }
        }

        $context = new SerializationContext();
        $context->setSerializeNull(true);
        $data = $this->arrayTransformer->toArray($card, $context);

        file_put_contents($filepath, $this->encode($data));
    }

    private function encode (array $data): string
    {
        return str_replace([
            '—',
            '--',
            '\\\\n',
        ], [
            '–',
            '–',
            '\n',
        ], json_encode([$data], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    private function askArray (InputInterface $input, OutputInterface $output, QuestionHelper $helper, Question $question): array
    {
        $answers = [];
        while ($answer = $helper->ask($input, $output, $question)) {
            $answers[] = $answer;
        }

        return $answers;
    }

    private function askBoolean (InputInterface $input, OutputInterface $output, QuestionHelper $helper, Question $question): bool
    {
        $question->setNormalizer(function ($value) {
            return strtolower($value) === 'y';
        });

        return $helper->ask($input, $output, $question);
    }
}
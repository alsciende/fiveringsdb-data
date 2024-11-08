<?php

namespace App\Command;

use App\Model\Card;
use App\Model\Clan;
use App\Model\Element;
use App\Model\Side;
use App\Model\Type;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:generate:card',
    description: 'Generate json file for a card',
)]
class GenerateCardCommand extends Command
{
    use JsonTrait;

    private readonly AsciiSlugger $slugger;

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
    )
    {
        $this->fs = new Filesystem();
        $this->slugger = new AsciiSlugger();
        parent::__construct();
    }

    #[\Override] protected function configure()
    {
        $this->addArgument('pack', InputArgument::REQUIRED, 'pack id');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var string $packId */
        $packId = $input->getArgument('pack');
        $filename = "./json/PackCard/{$packId}.json";
        if (!$this->fs->exists($filename)) {
            throw new \RuntimeException("File for pack {$packId} does not exist.");
        }

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $packs = array_values(array_filter(
            $this->getFileJsonContent('./json/Pack.json'),
            function (array $data) use ($packId) {
                return $data['id'] === $packId;
            }
        ));
        if (empty($packs)) {
            throw new \RuntimeException(sprintf('Unknown Pack %s -- aborting.', $packId));
        }
        $pack = $packs[0];
        $index = substr($pack['ffg_id'], -2);

        $card = new Card();
        $card->setName($helper->ask($input, $output, new Question('Name: ')));

        $card->setId($index . '-' . $this->slugger->slug($card->getName())->lower()->toString());
        $io->comment($card->getId() ?? '');

        $filepath = './json/Card/' . $card->getId() . '.json';
        if (file_exists($filepath)) {
            throw new \RuntimeException(sprintf('Card already exists at %s -- aborting.', $filepath));
        }

        $card->setClan($helper->ask($input, $output, new ChoiceQuestion('Clan: ', Clan::values())));
        $io->comment($card->getClan() ?? '');

        $card->setType($helper->ask($input, $output, new ChoiceQuestion('Type: ', Type::values())));
        $io->comment($card->getType() ?? '');

        $card->setTraits($this->askArray($input, $output, $helper, new Question('Traits: ')));
        $io->listing($card->getTraits());

        $question = new Question('Text: ');
        $question->setMultiline(true);
        $text = $helper->ask($input, $output, $question);
        $text = str_replace("\n", "<br>", $text);
        $text = str_replace("<em><b>", "<em>", $text);
        $text = str_replace("</b></em>", "</em>", $text);
        $card->setText($text);
        $io->comment($card->getText() ?? '');

        switch ($card->getType()) {
            case 'attachment':
                $card->setSide('conflict');
                $io->comment($card->getSide() ?? '');

                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $io->comment($card->getRoleRestriction() ?? '');

                $card->setIsUnique($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $io->comment($card->getIsUnique() ?? '');

                $card->setCost($helper->ask($input, $output, new Question('Cost: ')));
                $io->comment($card->getCost() ?? '');

                $card->setMilitaryBonus($helper->ask($input, $output, new Question('Military Bonus: ')));
                $io->comment($card->getMilitaryBonus() ?? '');

                $card->setPoliticalBonus($helper->ask($input, $output, new Question('Political Bonus: ')));
                $io->comment($card->getPoliticalBonus() ?? '');

                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                $io->comment($card->getDeckLimit() ?? '');

                break;
            case 'character':
                $card->setSide($helper->ask($input, $output, new ChoiceQuestion('Side: ', Side::values())));
                $io->comment($card->getSide() ?? '');

                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $io->comment($card->getRoleRestriction() ?? '');

                $card->setIsUnique($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $io->comment($card->getIsUnique() ?? '');

                $card->setCost($helper->ask($input, $output, new Question('Cost: ')));
                $io->comment($card->getCost() ?? '');

                $card->setMilitary($helper->ask($input, $output, new Question('Military Skill (can be empty): ')));
                $io->comment($card->getMilitary() ?? '');

                $card->setPolitical($helper->ask($input, $output, new Question('Political Skill (can be empty): ')));
                $io->comment($card->getPolitical() ?? '');

                $card->setGlory($helper->ask($input, $output, new Question('Glory: ')));
                $io->comment($card->getGlory() ?? '');

                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                $io->comment($card->getDeckLimit() ?? '');

                break;
            case 'event';
                $card->setSide($helper->ask($input, $output, new ChoiceQuestion('Side: ', Side::values(), 0)));
                $io->comment($card->getSide() ?? '');

                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $io->comment($card->getRoleRestriction() ?? '');

                $card->setCost($helper->ask($input, $output, new Question('Cost: ')));
                $io->comment($card->getCost() ?? '');

                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                $io->comment($card->getDeckLimit() ?? '');

                break;
            case 'holding':
                $card->setSide('dynasty');
                $io->comment($card->getSide() ?? '');

                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $io->comment($card->getRoleRestriction() ?? '');

                $card->setIsUnique($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $io->comment($card->getIsUnique() ?? '');

                $card->setStrengthBonus($helper->ask($input, $output, new Question('Strength Bonus: ')));
                $io->comment($card->getStrengthBonus() ?? '');

                $card->setDeckLimit($helper->ask($input, $output, new Question('Deck Limit (3): ', 3)));
                $io->comment($card->getDeckLimit() ?? '');

                break;
            case 'province':
                $elements = [];
                $elementChoices = Element::values();
                array_push($elementChoices, '');
                while ($answer = $helper->ask($input, $output, new ChoiceQuestion('Element: ', $elementChoices))) {
                    $elements[] = $answer;
                }
                $card->setElements($elements);
                $io->listing($card->getElements());

                $card->setSide('province');
                $io->comment($card->getSide() ?? '');

                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $io->comment($card->getRoleRestriction() ?? '');

                $card->setIsUnique($this->askBoolean($input, $output, $helper, new Question('Unique: (y/N) ', 'n')));
                $io->comment($card->getIsUnique() ?? '');

                $card->setStrength($helper->ask($input, $output, new Question('Strength: ')));
                $io->comment($card->getStrength() ?? '');

                $card->setDeckLimit(1);
                $io->comment($card->getDeckLimit() ?? '');

                break;
            case 'role':
                $card->setSide('role');
                $io->comment($card->getSide() ?? '');

                $card->setDeckLimit(1);
                $io->comment($card->getDeckLimit() ?? '');

                break;
            case 'stronghold':
                $card->setSide('province');
                $io->comment($card->getSide() ?? '');

                $card->setRoleRestriction($helper->ask($input, $output, new Question('Role Restriction: ')));
                $io->comment($card->getRoleRestriction() ?? '');

                $card->setStrengthBonus($helper->ask($input, $output, new Question('Strength Bonus: ')));
                $io->comment($card->getStrengthBonus() ?? '');

                $card->setHonor($helper->ask($input, $output, new Question('Honor: ')));
                $io->comment($card->getHonor() ?? '');

                $card->setFate($helper->ask($input, $output, new Question('Fate: ')));
                $io->comment($card->getFate() ?? '');

                $card->setInfluencePool($helper->ask($input, $output, new Question('Influence Pool: ')));
                $io->comment($card->getInfluencePool() ?? '');

                $card->setDeckLimit(1);
                $io->comment($card->getDeckLimit() ?? '');

                break;
        }

        if ($card->getSide() === 'conflict') {
            if ($card->getClan() !== 'neutral') {
                $card->setInfluenceCost($helper->ask($input, $output, new Question('Influence Cost: ')));
                $io->comment($card->getInfluenceCost() ?? '');

            } else {
                $card->setInfluenceCost(0);
                $io->comment($card->getInfluenceCost() ?? '');
            }
        }

        $constraintViolationList = $this->validator->validate($card);
        if (count($constraintViolationList) > 0) {
            foreach ($constraintViolationList as $constraintViolation) {
                /** @var ConstraintViolationInterface $constraintViolation */
                $output->writeln($constraintViolation->getMessage());
            }
        }

        $data = $this->serializer->serialize($card, 'json', [
            'json_encode_options' => \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE
        ]);

        file_put_contents($filepath, $data);

        $io->note("Card created at $filepath");

        $flavor = $helper->ask($input, $output, new Question('Flavor text: '));
        $illustrator = $helper->ask($input, $output, new Question('Illustrator: '));
        $imageUrl = $helper->ask($input, $output, new Question('Image URL: '));
        $position = (int) $helper->ask($input, $output, new Question('Position: '));
        $quantity = 3;
        if (($card->getType() === Type::PROVINCE->value && $card->getIsUnique())
        || $card->getType() === Type::ROLE->value
        || $card->getType() === Type::STRONGHOLD->value) {
            $quantity = 1;
        }
        $data = [
            "card_id" => $card->getId(),
            "flavor" => $flavor,
            "illustrator" => $illustrator,
            "image_url" => $imageUrl,
            "position" => $position,
            "quantity" => $quantity
        ];
        $filename = './json/PackCard/' . $pack['id'] . '.json';
        $cards = $this->getFileJsonContent($filename);
        $cards[] = $data;
        $this->putFileJsonContent($filename, $cards);

        return Command::SUCCESS;
    }

    /**
     * @return string[]
     */
    private function askArray(InputInterface $input, OutputInterface $output, QuestionHelper $helper, Question $question): array
    {
        $answers = [];
        while ($answer = $helper->ask($input, $output, $question)) {
            $answers[] = $answer;
        }

        return $answers;
    }

    private function askBoolean(InputInterface $input, OutputInterface $output, QuestionHelper $helper, Question $question): bool
    {
        $question->setNormalizer(fn($value): bool => strtolower((string) $value) === 'y');

        return $helper->ask($input, $output, $question);
    }
}

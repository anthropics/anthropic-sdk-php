<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

enum BetaComplianceReviewPolicyCategory: string
{
    case CYBER = 'cyber';

    case BIO = 'bio';

    case CHEM = 'chem';

    case RADNUC = 'radnuc';

    case CGW = 'cgw';

    case MGW = 'mgw';

    case IO = 'io';

    case FRAUD = 'fraud';

    case VIOLENT_EXTREMISM = 'violent_extremism';

    case SURVEILLANCE = 'surveillance';

    case HUMAN_EXPLOITATION = 'human_exploitation';

    case SELF_HARM = 'self_harm';

    case ADULT_CONTENT = 'adult_content';

    case REASONING_EXTRACTION = 'reasoning_extraction';

    case FRONTIER_LLM = 'frontier_llm';

    case COMPROMISED_KEY = 'compromised_key';

    case BENIGN = 'benign';

    case OTHER = 'other';

    case UNDETERMINED = 'undetermined';
}

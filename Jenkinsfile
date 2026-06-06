pipeline {
    agent any

    options {
        timestamps()
        timeout(time: 30, unit: 'MINUTES')
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

    environment {
        PHP_BIN = "php"
        COMPOSER_BIN = "composer"
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Checkout - Pulling latest code from GitHub (main branch)"
                    echo "=========================================="
                }
                checkout(
                    [
                        $class: 'GitSCM',
                        branches: [[name: '*/main']],
                        userRemoteConfigs: [[url: 'https://github.com/MedOverHeaven/drivado-codebase-v2']]
                    ]
                )
            }
        }

        stage('Environment Setup') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Environment Setup"
                    echo "=========================================="
                    
                    // Copy .env.example to .env if it doesn't exist
                    if (!fileExists('.env')) {
                        echo "Creating .env from .env.example..."
                        bat 'copy .env.example .env'
                    } else {
                        echo ".env already exists, skipping copy"
                    }
                    
                    // Display PHP version for verification
                    echo "PHP Version:"
                    bat '${PHP_BIN} --version'
                }
            }
        }

        stage('Dependencies') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Dependencies - Running composer install"
                    echo "=========================================="
                }
                bat '${COMPOSER_BIN} install --no-interaction --prefer-dist --no-progress'
            }
        }

        stage('Key Generation') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Key Generation - Running php artisan key:generate"
                    echo "=========================================="
                }
                bat '${PHP_BIN} artisan key:generate'
            }
        }

        stage('Database Migration') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Database Migration - Running php artisan migrate"
                    echo "=========================================="
                    echo "Using in-memory SQLite database for testing (configured in phpunit.xml)"
                }
                bat '${PHP_BIN} artisan migrate --force --env=testing'
            }
        }
stage('Tests') {
    steps {
        script {
            echo "=========================================="
            echo "Stage: Tests - Running php artisan test"
            echo "=========================================="
            
            def result = bat(
                script: 'php artisan test --no-coverage > test-output.txt 2>&1',
                returnStatus: true
            )
            bat 'type test-output.txt'
            if (result != 0) {
                unstable("Tests failed or had warnings")
            }
        }
    }
}

stage('Test Report') {
    steps {
        script {
            echo "=========================================="
            echo "Stage: Test Report"
            echo "=========================================="
            bat 'type test-output.txt || echo Test output file not found'
        }
    }
}

        stage('Test Report') {
            steps {
                script {
                    echo "=========================================="
                    echo "Stage: Test Report"
                    echo "=========================================="
                }
                bat 'cat test-output.txt || echo "Test output file not found"'
            }
        }
    }

    post {
        always {
            script {
                echo "=========================================="
                echo "Pipeline Completed"
                echo "=========================================="
            }
        }
        
        success {
            script {
                echo "✅ BUILD PASSED - All tests completed successfully!"
                // Send success notification
                emailext(
                    subject: "✅ Jenkins Build SUCCESS: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: '''
                        Build Status: SUCCESS
                        
                        Job: ${JOB_NAME}
                        Build Number: ${BUILD_NUMBER}
                        Build URL: ${BUILD_URL}
                        
                        All tests passed successfully.
                        Branch: main
                    ''',
                    to: '${DEFAULT_RECIPIENTS}',
                    recipientProviders: [
                        developers(),
                        requestor(),
                        brokenBuildSuspects()
                    ]
                )
            }
        }
        
        unstable {
            script {
                echo "⚠️  BUILD UNSTABLE - Some tests failed or warnings detected"
                emailext(
                    subject: "⚠️  Jenkins Build UNSTABLE: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: '''
                        Build Status: UNSTABLE
                        
                        Job: ${JOB_NAME}
                        Build Number: ${BUILD_NUMBER}
                        Build URL: ${BUILD_URL}
                        
                        Some tests failed or warnings were detected.
                        Please review the build logs.
                        Branch: main
                    ''',
                    to: '${DEFAULT_RECIPIENTS}',
                    recipientProviders: [
                        developers(),
                        requestor(),
                        brokenBuildSuspects()
                    ]
                )
            }
        }
        
        failure {
            script {
                echo "❌ BUILD FAILED - Pipeline encountered errors"
                emailext(
                    subject: "❌ Jenkins Build FAILED: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: '''
                        Build Status: FAILED
                        
                        Job: ${JOB_NAME}
                        Build Number: ${BUILD_NUMBER}
                        Build URL: ${BUILD_URL}
                        Build Log: ${BUILD_LOG_EXCERPT}
                        
                        The build failed. Please review the logs to identify the issue.
                        Branch: main
                    ''',
                    to: '${DEFAULT_RECIPIENTS}',
                    recipientProviders: [
                        developers(),
                        requestor(),
                        brokenBuildSuspects()
                    ]
                )
            }
        }
    }
}
